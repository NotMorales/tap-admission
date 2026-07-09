<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserPhotoController extends BaseApiController
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function upload(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $this->userService->find($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('users/photos', 'public');

        $user = $this->userService->update($id, [
            'photo' => $path,
        ]);

        return $this->resourceResponse(
            'User photo uploaded successfully.',
            new UserResource($user)
        );
    }
}
