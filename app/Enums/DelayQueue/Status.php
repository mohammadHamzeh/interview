<?php

namespace App\Enums\DelayQueue;

use App\Enums\Manager;
use App\Enums\PrepareValuesTrait;

class Status extends Manager
{
    use PrepareValuesTrait;

    public const PENDING = 'PENDING';
    public const REVIEWED = 'REVIEWED';

    public static string $type = 'delay_queue_status';
    public const VALUES = [
        self::PENDING,
        self::REVIEWED,
    ];
}
