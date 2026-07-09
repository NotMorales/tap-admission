<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileCollection;
use App\Http\Resources\ProfileResource;
use App\Services\ProfileService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ProfileService $profileService
    ) {}

    public function index(Request $request): ProfileCollection
    {
        $profiles = $this->profileService->paginate(
            filters: $request->only(['search', 'status', 'sort', 'direction']),
            perPage: (int) $request->get('per_page', 10)
        );

        return new ProfileCollection($profiles);
    }

    public function store(StoreProfileRequest $request): JsonResponse
    {
        $profile = $this->profileService->create($request->validated());

        return $this->successResponse(
            message: 'Profile created successfully.',
            data: new ProfileResource($profile),
            status: 201
        );
    }

    public function show(string $id): JsonResponse
    {
        $profile = $this->profileService->find($id);

        return $this->successResponse(
            message: 'Profile retrieved successfully.',
            data: new ProfileResource($profile)
        );
    }

    public function update(UpdateProfileRequest $request, string $id): JsonResponse
    {
        $profile = $this->profileService->update($id, $request->validated());

        return $this->successResponse(
            message: 'Profile updated successfully.',
            data: new ProfileResource($profile)
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->profileService->delete($id);

        return $this->successResponse(
            message: 'Profile deleted successfully.'
        );
    }
}
