<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseApiController
{
    public function __construct(
        private readonly ProductService $productService
    ) {}

    public function index(Request $request): ProductCollection
    {
        $products = $this->productService->paginate(
            filters: $request->only(['search', 'status', 'sort', 'direction']),
            perPage: (int) $request->get('per_page', 10)
        );

        return new ProductCollection($products);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->create($request->validated());

        return $this->resourceResponse(
            'Product created successfully.',
            new ProductResource($product),
            201
        );
    }

    public function show(string $id): JsonResponse
    {
        $product = $this->productService->find($id);

        return $this->resourceResponse(
            'Product retrieved successfully.',
            new ProductResource($product)
        );
    }

    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        $product = $this->productService->update($id, $request->validated());

        return $this->resourceResponse(
            'Product updated successfully.',
            new ProductResource($product)
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->productService->delete($id);

        return $this->deletedResponse('Product deleted successfully.');
    }
}
