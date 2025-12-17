<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'slug'        => $this->slug,
            'title'       => $this->title,
            'description' => $this->description,
            'views'       => $this->views,

            'category' => [
                'name' => $this->category?->name,
            ],

            'state' => [
                'name' => $this->state?->name,
            ],

            'municipio' => [
                'name' => $this->municipio?->name,
            ],

            // SOLO lo permitido del usuario
            'contact' => [
                'phone' => $this->user?->phone,
            ],
        ];
    }
}
