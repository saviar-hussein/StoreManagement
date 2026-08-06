<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;

    // Dependency Injection
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

public function index(Request $request): JsonResponse
{
    // Check if the frontend sent a ?search= parameter
    if ($request->has('search') && !empty($request->search)) {
        $products = $this->productService->search($request->search);
    } else {
        // Otherwise, just get all products
        $products = $this->productService->getAll();
    }

    return response()->json([
        'success' => true,
        'data' => $products
    ], 200);
}

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->productService->getById($id)
        ], 200);
    }


    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->create($request);
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function update(StoreProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productService->update($id, $request);
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->productService->delete($id);
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], 200);
    }
}