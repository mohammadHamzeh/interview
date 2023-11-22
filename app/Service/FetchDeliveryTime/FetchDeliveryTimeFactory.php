<?php

namespace App\Service\FetchDeliveryTime;

use App\Dto\FetchDeliveryTimeOutputDto;
use App\Enums\Provider\FetchDeliveryTimeProvider;
use App\Service\FetchDeliveryTime\Mocky\FetchDeliveryTime;

class FetchDeliveryTimeFactory
{
    private const OPERATIONS = [
        FetchDeliveryTimeProvider::MOCKY => FetchDeliveryTime::class
    ];

    public  static function make(): FetchDeliveryTimeOutputDto
    {
        $provider = config('app.fetchDeliveryTimeProvider');
        return app(self::OPERATIONS[$provider])->fetchDeliveryTime();
    }
}