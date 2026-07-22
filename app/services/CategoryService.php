<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * Get all categories
     */
    public function getAllCategories()
    {
        return Category::all();
    }

    /**
     * Get category by ID
     */
    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Create new category
     */
    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    /**
     * Update category
     */
    public function updateCategory(Category $category, array $data)
    {
        $category->update($data);
        return $category->fresh();
    }

    /**
     * Delete category
     */
    public function deleteCategory(Category $category)
    {
        return $category->delete();
    }
}