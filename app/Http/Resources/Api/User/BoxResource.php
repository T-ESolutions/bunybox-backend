<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxResource extends JsonResource
{

    private static $data;



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
            'price' => $this->price,
            'sold_out' => 0,
            'categories' => BoxCategoriesResource::collection($this->categoriesByData($this->main_category_id,self::$data)),
        ];
    }



    public static function customCollection($resource, $request_data)
    {

        //you can add as many params as you want.
        self::$data = $request_data;
        return parent::collection($resource);
    }


}
