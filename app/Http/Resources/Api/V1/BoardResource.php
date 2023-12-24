<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'board_code' => $this->board_code,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'progress' => $this->progress . ' %',
        ];
    }
}
