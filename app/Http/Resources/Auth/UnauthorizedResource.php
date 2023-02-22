<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnauthorizedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'error' => [
                'message' => 'Unauthenticated.'
            ]
        ];
    }

    public static $wrap = false;

}
