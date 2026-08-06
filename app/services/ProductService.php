<?php

namespace App\Services;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;

class ProductService
{
    // Get all products (with their category name)
    public function getAll()
    {

        // Eager loading the category prevents the N+1 query problem
        return Product::with('category')->orderBy('created_at', 'desc')->get();
    }


public function search(?string $search = null)
{
    // If no search term is provided, just return all products
    if (empty($search)) {
        return $this->getAll();
    }

    // Use a closure to group the OR conditions safely
    return Product::where(function ($query) use ($search) {
        $query->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
    })
    ->with('category') // Eager load to prevent N+1
    ->orderBy('created_at', 'desc')
    ->get();
}
    // Get a single product by ID
    public function getById(int $id)
    {
        return Product::with('category')->findOrFail($id);
    }

    // Create a new product
    public function create(StoreProductRequest $request)
    {
        return Product::create($request->validated());
    }

    // Update an existing product
    public function update(int $id, StoreProductRequest $request)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        return $product;
    }

    // Delete a product
    public function delete(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    // SLICE 2 SPECIAL: Get low stock items for the Dashboard
    public function getLowStockItems(int $threshold = 10)
    {
        return Product::where('stock_quantity', '<=', $threshold)
            ->orderBy('stock_quantity', 'asc')
            ->with('category')
            ->get();
    }
}