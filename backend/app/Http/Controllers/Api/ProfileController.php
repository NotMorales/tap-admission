<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileCollection;
use App\Http\Resources\ProfileResource;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends BaseApiController
{
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

        return $this->resourceResponse(
            'Profile created successfully.',
            new ProfileResource($profile),
            201
        );
    }

    public function show(string $id): JsonResponse
    {
        $profile = $this->profileService->find($id);

        return $this->resourceResponse(
            'Profile retrieved successfully.',
            new ProfileResource($profile)
        );
    }

    public function update(UpdateProfileRequest $request, string $id): JsonResponse
    {
        $profile = $this->profileService->update($id, $request->validated());

        return $this->resourceResponse(
            'Profile updated successfully.',
            new ProfileResource($profile)
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->profileService->delete($id);

        return $this->deletedResponse('Profile deleted successfully.');
    }
}
