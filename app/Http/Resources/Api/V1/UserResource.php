<?php

namespace App\Http\Resources\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'token' => $this->createToken($this->createUserToken($this->resource))->plainTextToken,
        ];
    }

    /**
     * @param User $user
     * @return string
     */
    private function createUserToken(User $user): string
    {
        return "API_TOKEN_V1_" . $user->email . '_' . now()->timestamp;
    }
}
