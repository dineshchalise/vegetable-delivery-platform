<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkPriceUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return Product::with('category')
            ->when($request->query('category_id'), fn ($q, $id) => $q->where('category_id', $id))
            ->latest()
            ->paginate(25);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $product = Product::create($data);
        Cache::flush();

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return $product->load('category');
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request, $product->id);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $product->update($data);
        Cache::flush();

        return $product->refresh();
    }

    public function destroy(Product $product)
    {
        $product->delete();
        Cache::flush();

        return response()->noContent();
    }

    public function bulkPrice(BulkPriceUpdateRequest $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request->validated('prices') as $row) {
                Product::whereKey($row['product_id'])->update(['price' => $row['price']]);
            }
        });

        Cache::flush();

        return response()->json(['message' => 'Prices updated.']);
    }

    public function bulkPublish(Request $request)
    {
        $data = $request->validate([
            'product_ids' => ['required', 'array'],
            'product_ids.*' => ['exists:products,id'],
            'is_published' => ['required', 'boolean'],
        ]);

        Product::whereIn('id', $data['product_ids'])->update(['is_published' => $data['is_published']]);
        Cache::flush();

        return response()->json(['message' => 'Products updated.']);
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:140', 'unique:products,slug,'.$id],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'max:20'],
            'stock_quantity' => ['required', 'numeric', 'min:0'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'is_published' => ['required', 'boolean'],
        ]);
    }
}
