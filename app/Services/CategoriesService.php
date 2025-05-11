<?php
namespace App\Services;

use App\Models\Categories;
class CategoriesService
{
    /**
     * Create a new category.
     *
     * @param array $data
     * @return Categories
     */
    public function create(array $data)
    {
        try {
            $category = new Categories();
            $category->name = $data["name"];
            $category->description = $data["description"];
            $category->save();
            return $category;
        } catch (\Exception $e) {
            return ['error' => 'Category creation failed: ' . $e->getMessage()];
        }
    }
    /**
     * Update an existing category.
     *
     * @param Categories $category
     * @param array $data
     * @return Categories
     */
    public function update(array $data, $id)
    {
        try {
            $category = Categories::find($id);
            if (!$category) {
                return ['error' => 'Category not found'];
            }

            $category = Categories::find($id);
            $category->name = $data["name"];
            $category->description = $data["description"];
            $category->save();
            return $category;

        } catch (\Exception $e) {
            return ['error' => 'Category not found: ' . $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $category = Categories::find($id);
            if (!$category) {
                return ['error' => 'Category not found'];
            }
            $category->delete();
            return ['message' => 'Category deleted successfully'];
        } catch (\Exception $e) {
            return ['error' => 'Category deletion failed: ' . $e->getMessage()];
        }
    }

    /**
     * Get all categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        try {
            return Categories::all();
        } catch (\Exception $e) {
            return ['error' => 'Failed to retrieve categories: ' . $e->getMessage()];
        }
    }

    public function show($id)
    {
        try {
            $category = Categories::find($id);
            if (!$category) {
                return ['error' => 'Category not found' ];
            }
            return $category;
        } catch (\Exception $e) {
            return ['error' => 'Failed to retrieve category: ' . $e->getMessage()];
        }
    }
}
