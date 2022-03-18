<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        $totalPrice = (($this->product->price * $this->quality) / 100 ) * ($this->product->discount == null ? 100 : $this->product->discount);
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product_name' => $this->product->name,
//            'product_price' => $this->product->price,
//            'discount' => $this->product->discount,
//            'quality' => $this->quality,
//            'product_total_price' => '$totalPrice',
//            'status' => config('status.status.'.$this->status),
        ];
    }
}
