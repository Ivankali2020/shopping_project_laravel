<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'cart_id' => $this->id,
            'product_quality' => $this->quality,
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'product_price' => $this->product->price,
            'product_discount' => $this->product->discount,
            'product_image' => asset('storage/productPhoto/'.$this->product->photo),
            'hearts' => $this->product->hearts->count(),
            'category_name' => $this->product->category->name,
            'brand_name' => $this->product->brand->name,
        ];
    }
}
