<?php

namespace App\Contracts\Repository;

interface DelayReportRepository extends Repository
{
    public function vendorDelayed();
}
