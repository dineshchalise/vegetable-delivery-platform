<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HubController extends Controller
{
    public function index()
    {
        return Hub::latest()->paginate(25);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['photo_url'] = $this->storePhoto($request) ?? $data['photo_url'] ?? null;
        Cache::forget('hubs.active');

        return response()->json(Hub::create($data), 201);
    }

    public function show(Hub $hub)
    {
        return $hub;
    }

    public function update(Request $request, Hub $hub)
    {
        $data = $this->validated($request);
        $data['photo_url'] = $this->storePhoto($request) ?? $data['photo_url'] ?? $hub->photo_url;
        $hub->update($data);
        Cache::forget('hubs.active');

        return $hub->refresh();
    }

    public function destroy(Hub $hub)
    {
        $hub->delete();
        Cache::forget('hubs.active');

        return response()->noContent();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'photo_url' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'contact_number' => ['required', 'string', 'max:30'],
            'pickup_timings' => ['required', 'string', 'max:120'],
            'is_active' => ['required', 'boolean'],
        ]);
    }

    private function storePhoto(Request $request): ?string
    {
        if (! $request->hasFile('photo')) {
            return null;
        }

        return Storage::disk('public')->url($request->file('photo')->store('hubs', 'public'));
    }
}
