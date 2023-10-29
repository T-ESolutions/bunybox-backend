<?php

namespace App\Http\Resources\Api\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
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
                'status' => $this->status,
                'completed_at' => $this->delivered_at,
                'main_category_title' => $this->mainCategory ? $this->mainCategory->title : '',
                'box_image' => $this->box->image,
                'box_title' => $this->box->title,
                'box_price' => $this->box->price,
                'box_categories' => $categories_arr,
                'delivery_address' => new AddressesResources($this->address_data),
                'total' => $this->total,
                'payment_method' => $this->payment_method,
                'ordered_at' => Carbon::parse($this->created_at)->translatedFormat("Y-m-d h:i a"),

            ];
    }


}
