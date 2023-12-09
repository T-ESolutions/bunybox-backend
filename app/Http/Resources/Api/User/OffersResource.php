<?php

namespace App\Http\Resources\Api\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OffersResource extends JsonResource
{

    private static $count;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $end_time = Carbon::parse($this->offer_end_time);
        $today = Carbon::now();
        $diferent = $today->diffInSeconds($end_time);
        return
            [
                'id' => $this->id,
                'image' => $this->image,
                'title' => $this->title,
                'price' => $this->offer_price,
                'description' => $this->desc,
                'offer_end_time' => $this->offer_end_time,
                'remain_time_in_seconds' => $diferent,
//                'products' => ProductResource::collection($this->offer_products)
                'products' => $this->offer_products
            ];


    }

    public static function customCollection($resource, $count)
    {

        //you can add as many params as you want.
        self::$count = $count;
        return parent::collection($resource);
    }

}
