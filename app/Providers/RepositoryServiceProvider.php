<?php

namespace App\Providers;

use App\Contracts\Repository\AgentRepository;
use App\Contracts\Repository\DelayQueueRepository;
use App\Contracts\Repository\DelayReportRepository;
use App\Contracts\Repository\OrderRepository;
use App\Contracts\Repository\TripRepository;
use App\Contracts\Repository\VendorRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AgentRepository::class => \App\Repositories\AgentRepository::class,
        DelayQueueRepository::class => \App\Repositories\DelayQueueRepository::class,
        DelayReportRepository::class => \App\Repositories\DelayReportRepository::class,
        OrderRepository::class => \App\Repositories\OrderRepository::class,
        TripRepository::class => \App\Repositories\TripRepository::class,
        VendorRepository::class => \App\Repositories\VendorRepository::class
    ];
}
