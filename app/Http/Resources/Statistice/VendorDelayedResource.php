<?php

namespace App\Http\Resources\Statistice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorDelayedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'vendor_id'=>$this->vendor_id,
            'title'=>$this->title,
            'sum_delay_time'=>$this->sum_delay_time,
        ];
    }
}
