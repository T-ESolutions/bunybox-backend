<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
                'product_id' => $this->id,
                'category_id' => $this->category->id,
                'category_title' => $this->category->title,
                'category_description' => $this->category->description,
                'product_description' => $this->description,


            ];
    }
}
