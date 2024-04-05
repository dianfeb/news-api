<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $slug = Str::slug($this->name); // Membuat slug dari nama kategori
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $slug
        ];
    }
}
