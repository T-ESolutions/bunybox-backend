<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxFinalResource extends JsonResource
{

    private static $data;


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //generate sold_out....

        $count = 0;
        foreach ($this->products as $product) {
            if ($product['is_show'] == 1) {
                $count++;
            }
        }

        if ($count >= 1) {
            $sold_out = 0;
        } else {
            $sold_out = 1;
        }
        return
            [
                'id' => $this->id,
                'hint' => $this->hint,
                'image' => $this->image,
                'title' => $this->title,
                'description' => $this->desc,
                'price' => $this->price,
                'min_price' => $this->min_price,
                'max_price' => $this->max_price,
                'sold_out' => $sold_out,
                'categories' => ProductResource::collection($this->products)
//                'categories' => BoxCategoriesFinalResource::customcollection($this->categoriesByData($this->main_category_id,
//                    self::$data), $category_count, $products),
            ];
    }


    public static function customCollection($resource, $request_data)
    {

        //you can add as many params as you want.
        self::$data = $request_data;
        return parent::collection($resource);
    }


}
