<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Hub;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CatalogController extends Controller
{
    public function products(Request $request)
    {
        $category = $request->query('category');
        $cacheKey = 'products.active.'.($category ?: 'all');

        return Cache::remember($cacheKey, now()->addHour(), function () use ($category) {
            return Product::with('category')
                ->where('is_published', true)
                ->when($category, fn ($query) => $query->whereHas('category', fn ($q) => $q->where('slug', $category)))
                ->orderBy('name')
                ->get();
        });
    }

    public function categories()
    {
        return Cache::remember('categories.active', now()->addDay(), function () {
            return Category::where('is_active', true)->orderBy('display_order')->get();
        });
    }

    public function hubs()
    {
        return Cache::remember('hubs.active', now()->addDay(), function () {
            return Hub::where('is_active', true)->orderBy('name')->get();
        });
    }
}
