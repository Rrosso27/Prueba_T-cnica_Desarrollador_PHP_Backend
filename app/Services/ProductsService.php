<?php
namespace App\Services;

use App\Models\Products;

class ProductsService
{
    /**
     * Create a new product.
     *
     * @param array $data
     * @return Products
     */
    public function create(array $data)
    {
        try {
            $product = new Products();
            $product->category_id = $data["category_id"];
            $product->name = $data["name"];
            $product->description = $data["description"];
            $product->price = $data["price"];
            $product->stock = $data["stock"];
            $product->save();


            return $product;
        } catch (\Exception $e) {
            return ['error' => 'Product creation failed: ' . $e->getMessage()];
        }
    }
    /**
     * Update an existing product.
     *
     * @param Products $product
     * @param array $data
     * @return Products
     */
    public function update(array $data, $id)
    {
        try {
            $product = Products::find($id);
            if (!$product) {
                return ['error' => 'Product not found'];
            }

            $product->category_id = $data["category_id"];
            $product->name = $data["name"];
            $product->description = $data["description"];
            $product->price = $data["price"];
            $product->stock = $data["stock"];
            $product->save();
            return $product;

        } catch (\Exception $e) {
            return ['error' => 'Product not found: ' . $e->getMessage()];
        }
    }
    /**
     * Delete a product.
     *
     * @param int $id
     * @return array
     */
    public function delete($id)
    {
        try {
            $product = Products::find($id);
            if (!$product) {
                return ['error' => 'Product not found'];
            }
            $product->delete();
            return ['message' => 'Product deleted successfully'];
        } catch (\Exception $e) {
            return ['error' => 'Product deletion failed: ' . $e->getMessage()];
        }
    }

    /**
     * Get all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        try {
            return Products::with('categories:id,name')
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'category' => $product->categories ? $product->categories->name : null,
                    ];
                });
        } catch (\Exception $e) {
            return ['error' => 'Failed to retrieve products: ' . $e->getMessage()];
        }
    }
    /**
     * Get a product by ID.
     *
     * @param int $id
     * @return Products|null
     */
    public function show($id)
    {
        try {
            $product = Products::with('categories:id,name')->find($id);
            if (!$product) {
                return ['error' => 'Product not found'];
            }
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'category' => $product->categories ? $product->categories->name : null,
            ];
        } catch (\Exception $e) {
            return ['error' => 'Failed to retrieve product: ' . $e->getMessage()];
        }
    }
}



