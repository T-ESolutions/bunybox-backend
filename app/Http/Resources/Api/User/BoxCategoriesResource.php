<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxCategoriesResource extends JsonResource
{

    private static $count;

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
            'products' => ProductResource::collection($this->products)
        ];


    }

    public static function customCollection($resource, $count)
    {

        //you can add as many params as you want.
        self::$count = $count;
        return parent::collection($resource);
    }

}
