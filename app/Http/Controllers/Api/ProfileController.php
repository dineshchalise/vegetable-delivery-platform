<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return $request->user();
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'address' => ['required', 'string', 'max:1000'],
        ]);

        $request->user()->update($data);

        return $request->user()->refresh();
    }
}
