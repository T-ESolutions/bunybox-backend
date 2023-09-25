<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxCategoriesFinalResource extends JsonResource
{

    private static $count;
    private static $products;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        $products = self::$products;
        foreach ($products as $product){
            if ($product['category_id'] == $this->id ){
                $new_pro = $product;
                break;
            }
        }

        return
            [
                'id' => $this->id,
                'image' => $this->image,
                'title' => $this->title,
                'description' => $this->desc,
                'products' => new ProductResource($new_pro)
            ];


    }

    public static function customCollection($resource, $count, $products)
    {

        //you can add as many params as you want.
        self::$count = $count;
        self::$products = $products;
        return parent::collection($resource);
    }

}
