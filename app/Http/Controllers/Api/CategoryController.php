<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * GET /api/categories
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();

        return response()->json([
            'success' => true,
            'data' => $categories
        ], 200);
    }

    /**
     * GET /api/categories/{id}
     */
    public function show($id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);

        return response()->json([
            'success' => true,
            'data' => $category
        ], 200);
    }

    /**
     * POST /api/categories
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    /**
     * PUT /api/categories/{id}
     */
    public function update(UpdateCategoryRequest $request, $id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);
        $updated = $this->categoryService->updateCategory($category, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $updated
        ], 200);
    }

    /**
     * DELETE /api/categories/{id}
     */
    public function destroy($id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);
        $this->categoryService->deleteCategory($category);

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ], 200);
    }
}