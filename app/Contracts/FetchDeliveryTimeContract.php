<?php

namespace App\Contracts;

use App\Dto\FetchDeliveryTimeOutputDto;

interface FetchDeliveryTimeContract
{
    public function fetchDeliveryTime():FetchDeliveryTimeOutputDto;
}