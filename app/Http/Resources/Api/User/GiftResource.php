<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class GiftResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (isset($this->amount)) {
            $image = setting_image('gift_money_image');
            $title = $this->amount;
        } else {
            $image = $this->image;
            $title = $this->title;
        }
        return
            [
                'image' => $image,
                'title' => $title,
            ];

    }


}
