<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductsService;
use App\Http\Requests\ProductsRequest;
class ProductsController extends Controller
{
    public function __construct(ProductsService $productsService)
    {
        $this->productsService = $productsService;
    }
    /**
     * Store a new product.
     *
     * @param ProductsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductsRequest $request)
    {
        try {
            $this->authorize('create', Products::class);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unauthorized', 'errors' => $e->getMessage()], 403);
        }
        try {
            $data = $request->only('category_id', 'name', 'description', 'price', 'stock');
            $response = $this->productsService->create($data);
            return response()->json(['success' => true, 'message' => 'product stored correctly', 'data' => $response], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Product creation failed', 'errors' => $e->getMessage()], 422);
        }
    }
    /**
     * Update an existing product.
     *
     * @param ProductsRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductsRequest $request, $id)
    {
        try {
            $this->authorize('update', Products::class);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unauthorized', 'errors' => $e->getMessage()], 403);
        }
        try {
            $data = $request->only('category_id', 'name', 'description', 'price', 'stock');
            $response = $this->productsService->update($data, $id);
            if (isset($response['error'])) {
                return response()->json(['success' => false, 'error' => $response['error'], 'errors' => 'error '], 404);
            }
            return response()->json(['success' => true, 'message' => 'product updated successfully', 'data' => $response], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Product update failed ', 'errors' => $e->getMessage()], 422);
        }
    }
    /**
     * Delete a product.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->authorize('delete', Products::class);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unauthorized', 'errors' => $e->getMessage()], 403);
        }
        try {
            $response = $this->productsService->delete($id);
            if (isset($response['error'])) {
                return response()->json(['success' => false, 'error' => $response['error'], 'errors' => 'error'], 404);
            }
            return response()->json(['success' => true, 'message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Product deletion failed', 'errors' => $e->getMessage()], 422);
        }
    }
    /**
     * Get all products.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $products = $this->productsService->getAll();
            return response()->json(['success' => true, 'data' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to retrieve products', 'errors' => $e->getMessage()], 422);
        }
    }
    /**
     * Get a product by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $product = $this->productsService->show($id);
            if (isset($product['error'])) {
                return response()->json(['success' => false, 'error' => $product['error'], 'errors' => 'error'], 404);
            }
            return response()->json(['success' => true, 'data' => $product], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to retrieve product', 'errors' => $e->getMessage()], 422);
        }
    }

}
