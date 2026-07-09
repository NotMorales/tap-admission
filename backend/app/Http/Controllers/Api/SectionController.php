<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Http\Resources\SectionCollection;
use App\Http\Resources\SectionResource;
use App\Services\SectionService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly SectionService $sectionService
    ) {}

    public function index(Request $request): SectionCollection
    {
        $sections = $this->sectionService->paginate(
            filters: $request->only(['search', 'status', 'sort', 'direction']),
            perPage: (int) $request->get('per_page', 10)
        );

        return new SectionCollection($sections);
    }

    public function store(StoreSectionRequest $request): JsonResponse
    {
        $section = $this->sectionService->create($request->validated());

        return $this->successResponse(
            message: 'Section created successfully.',
            data: new SectionResource($section),
            status: 201
        );
    }

    public function show(string $id): JsonResponse
    {
        $section = $this->sectionService->find($id);

        return $this->successResponse(
            message: 'Section retrieved successfully.',
            data: new SectionResource($section)
        );
    }

    public function update(UpdateSectionRequest $request, string $id): JsonResponse
    {
        $section = $this->sectionService->update($id, $request->validated());

        return $this->successResponse(
            message: 'Section updated successfully.',
            data: new SectionResource($section)
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->sectionService->delete($id);

        return $this->successResponse(
            message: 'Section deleted successfully.'
        );
    }
}
