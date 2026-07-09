<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseApiController
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function index(Request $request): UserCollection
    {
        $users = $this->userService->paginate(
            filters: $request->only(['search', 'status', 'sort', 'direction']),
            perPage: (int) $request->get('per_page', 10)
        );

        return new UserCollection($users);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->validated());

        return $this->resourceResponse(
            'User created successfully.',
            new UserResource($user),
            201
        );
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->userService->find($id);

        return $this->resourceResponse(
            'User retrieved successfully.',
            new UserResource($user)
        );
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = $this->userService->update($id, $request->validated());

        return $this->resourceResponse(
            'User updated successfully.',
            new UserResource($user)
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->userService->delete($id);

        return $this->deletedResponse('User deleted successfully.');
    }
}
