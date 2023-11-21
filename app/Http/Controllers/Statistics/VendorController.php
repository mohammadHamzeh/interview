<?php

namespace App\Http\Controllers\Statistics;

use App\Contracts\Repository\DelayReportRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\Statistice\VendorDelayedCollection;

class VendorController extends Controller
{
    public function __construct(
        private readonly DelayReportRepository $delayReportRepository
    ) {
    }

    public function vendorDelayed(): VendorDelayedCollection
    {
        return VendorDelayedCollection::make($this->delayReportRepository->vendorDelayed());
    }
}
