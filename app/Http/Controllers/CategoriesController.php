<?php

namespace App\Http\Controllers;

use App\Services\CategoriesService;
use App\Http\Requests\CategoriesRequest;
use GuzzleHttp\Psr7\Request;

class CategoriesController extends Controller
{
    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }
    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $this->authorize('viewAny', Categories::class);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unauthorized ', 'errors' => $e->getMessage()], 403);
        }

        try {
            $categories = $this->categoriesService->get();
            if (isset($categories['error'])) {
                return response()->json(['success' => false, 'message' => $categories['error'], 'errors' => 'error'], 500);
            }
            return response()->json(['success' => true, 'data' => $categories], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'error', 'errors' => $e->getMessage()], 500);
        }
    }
    /**
     * Summary of store
     * @param \App\Http\Requests\CategoriesRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */

    public function create(CategoriesRequest $request)
    {

        try {
            $this->authorize('create', Categories::class);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unauthorized', 'errors' => $e->getMessage()], 403);
        }
        try {
            $data = $request->only('name', 'description');
            $category = $this->categoriesService->create($data);
            if (isset($category['error'])) {
                return response()->json(['success' => false, 'message' => $category['error'], 'errors' => 'error'], 422);
            }
            return response()->json(['success' => true, 'message' => 'Categoría creada exitosamente', "data" => $category], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error creating category', 'errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\CategoriesRequest $request
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(CategoriesRequest $request, $id)
    {
        try {
            $this->authorize('update', Categories::class);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unauthorized', 'errors' => $e->getMessage()], 403);
        }
        try {
            $data = $request->only('name', 'description');
            $category = $this->categoriesService->update($data, $id);

            if (isset($category['error'])) {
                return response()->json(['success' => false, 'error' => $category['error'], 'errors' => 'error'], 404);
            }

            return response()->json(['success' => true, 'message' => 'Categoría actualizada correctamente', "data" => $category], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating category: ', 'errors' => $e->getMessage()], 500);
        }
    }
    /**
     * Summary of destroy
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->authorize('delete', Categories::class);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unauthorized', 'errors' => $e->getMessage()], 403);
        }

        try {
            $response = $this->categoriesService->delete($id);
            if (isset($response['error'])) {
                return response()->json(['success' => false, 'message' => $response['error'], 'errors' => 'error'], 404);
            }
            return response()->json(['success' => true, 'data' => $response], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting category: ', 'errors' => $e->getMessage()], 500);
        }
    }
    /**
     * Summary of show
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        try {
            $this->authorize('view', Categories::class);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unauthorized', 'errors' => $e->getMessage()], 403);
        }

        try {
            $category = $this->categoriesService->show($id);
            if (isset($category['error'])) {
                return response()->json(['success' => false, 'message' => $category['error'], 'errors' => 'error'], 404);
            }
            return response()->json(['success' => true, 'data' => $category], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error fetching category', 'errors' => $e->getMessage()], 500);
        }
    }
}
