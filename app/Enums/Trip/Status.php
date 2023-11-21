<?php

namespace App\Enums\Trip;

use App\Enums\Manager;
use App\Enums\PrepareValuesTrait;

class Status extends Manager
{
    use PrepareValuesTrait;

    public const DELIVERED = 'DELIVERED';
    public const PICKED = 'PICKED';
    public const AT_VENDOR = 'AT_VENDOR';
    public const ASSIGNED = 'ASSIGNED';

    public static string $type = 'trip_status';

    public const VALUES = [
        self::DELIVERED,
        self::PICKED,
        self::AT_VENDOR,
        self::ASSIGNED,
    ];
}
