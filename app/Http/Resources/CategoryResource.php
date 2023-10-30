<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray( $request)
    {
        return [
            'id' => $this->id,
            'type' => 'category',
            'atributes' => [
                'name' => $this->name,
                
            ],
            'relationships' =>[
                'recipes'=>RecipeResource::collection($this->recipes)
            ],
        ];
    }
}
