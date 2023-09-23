<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return
        [
            'id' => $this->id,
            'image' => $this->image,
            'title' => $this->title,
            'description' => $this->desc,
            'type' => 'show',
            'product' => ProductResource::collection($this->products)


        ];
    }
}
