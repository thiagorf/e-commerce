<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public static $wrap = 'category'; 
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tag' => $this->tag,
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
