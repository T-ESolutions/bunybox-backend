<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressesResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */


    public function toArray($request)
    {

        return [
            'id' => (int)$this->id,
            'address' => (string)$this->address,
            'phone' => (string)$this->phone,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'is_default' => (int)$this->is_default,
        ];
    }


}
