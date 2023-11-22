<?php

namespace App\Service\FetchDeliveryTime\Mocky;

use App\Contracts\FetchDeliveryTimeContract;
use App\Dto\FetchDeliveryTimeOutputDto;
use Illuminate\Support\Facades\Http;

class FetchDeliveryTime implements FetchDeliveryTimeContract
{

    public function fetchDeliveryTime(): FetchDeliveryTimeOutputDto
    {
        $result = Http::get('https://run.mocky.io/v3/122c2796-5df4-461c-ab75-87c1192b17f7');
        return FetchDeliveryTimeOutputDto::fromArray([
            'deliveryTime' => $result->json('time')
        ]);
    }
}