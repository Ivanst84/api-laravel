<?php

namespace App\Http\Resources;

use App\Models\Category;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray( $request)
    {    
           return $this->collection->map(function($category){

        return [
            'id' => $category->id,
            'type' => 'category',
            'atributes' => [
                'name' => $category->name,
                
            ]
           
        ];
    }) ->toArray();
    }
}