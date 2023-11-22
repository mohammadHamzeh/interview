<?php

namespace App\Dto;

class FetchDeliveryTimeOutputDto extends BaseDto
{
    public function __construct(
        private readonly string $deliveryTime
    )
    {
    }

    public function getDeliveryTime(): string
    {
        return $this->deliveryTime;
    }
}