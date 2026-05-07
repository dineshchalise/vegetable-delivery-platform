<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::orderBy('display_order')->get();
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        Cache::forget('categories.active');

        return response()->json(Category::create($data), 201);
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validated($request, $category->id);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $category->update($data);
        Cache::forget('categories.active');

        return $category->refresh();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        Cache::forget('categories.active');

        return response()->noContent();
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            'categories' => ['required', 'array'],
            'categories.*.id' => ['required', 'exists:categories,id'],
            'categories.*.display_order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($data['categories'] as $row) {
            Category::whereKey($row['id'])->update(['display_order' => $row['display_order']]);
        }

        Cache::forget('categories.active');

        return response()->json(['message' => 'Categories reordered.']);
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:140', 'unique:categories,slug,'.$id],
            'display_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);
    }
}
