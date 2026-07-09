<?php

namespace App\Http\Resources;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $profiles = Profile::query()
            ->whereIn('_id', $this->profile_ids ?? [])
            ->whereNull('deleted_at')
            ->get();

        return [
            'id' => (string) $this->_id,
            'code' => $this->code,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'photo_url' => $this->photo ? asset('storage/' . $this->photo) : null,
            'profile_ids' => $this->profile_ids,
            'profiles' => ProfileResource::collection($profiles),
            'status' => $this->status,
            'created_at' => optional($this->created_at)->format('d/m/Y H:i'),
        ];
    }
}
