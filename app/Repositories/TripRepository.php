<?php

namespace App\Repositories;

use App\Models\Trip;

class TripRepository extends BaseRepository implements \App\Contracts\Repository\TripRepository
{
    protected function model(): string
    {
        return Trip::class;
    }
}
