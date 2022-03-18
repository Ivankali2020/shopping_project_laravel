<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'stock' => $this->stock ,
            'price' => $this->price ,
            'detail' => $this->detail,
            'photo' => asset('storage/productPhoto/'.$this->photo),
            'category_id' => $this->category->id,
            'category_name' => $this->category->name,
            'brand_name' => $this->brand->name,
            'brand_id' => $this->brand->id,
            'product_code' => $this->product_code,
            'hearts' => count($this->hearts),
            'discount' => $this->discount,
        ];
    }
}
