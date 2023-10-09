<?php

namespace App\Http\Resources\Api\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $categories_arr = [];
        foreach ($this->items as $item) {
            array_push($categories_arr, $item->category->title);
        }

        return
            [
                'id' => $this->id,
                'main_category_title' => $this->mainCategory->title,
                'box_image' => $this->box->image,
                'box_title' => $this->box->title,
                'box_price' => $this->box->price,
                'box_categories' => $categories_arr,
                'ordered_at' => Carbon::parse($this->created_at)->translatedFormat("Y-m-d h:i a"),

            ];
    }


}
