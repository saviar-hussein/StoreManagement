<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    
      //Get all categories
     
      
      //$search receives the value passed from the CategoryController.
    public function getAllCategories(?string $search = null)
    {

        $query = Category::query();
        if($search) {
            $query->where('name', 'like', "%{$search}%");
            $query->orWhere('description', 'like', "%{$search}%");
        }
        return $query->get();
    }

    
      //Get category by ID
     
    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }

    
     // Create new category
     
    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    
     // Update category
     
    public function updateCategory(Category $category, array $data)
    {
        $category->update($data);
        return $category->fresh();
    }

    
     //Delete category
     
    public function deleteCategory(Category $category)
    {
        return $category->delete();
    }
}