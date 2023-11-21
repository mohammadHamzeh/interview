<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository extends BaseRepository implements \App\Contracts\Repository\OrderRepository
{
    protected function model(): string
    {
        return Order::class;
    }
}
