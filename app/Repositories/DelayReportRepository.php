<?php

namespace App\Repositories;

use App\Models\DelayReport;
use Illuminate\Database\Eloquent\Collection;

class DelayReportRepository extends BaseRepository implements \App\Contracts\Repository\DelayReportRepository
{
    protected function model(): string
    {
        return DelayReport::class;
    }

    public function vendorDelayed(): Collection|array
    {
        return $this->model->query()
            ->selectRaw('vendor_id, SUM(delay_time) AS sum_delay_time, vendors.title')
            ->join('vendors', 'vendors.id', 'delay_reports.vendor_id')
            ->groupBy('vendor_id', 'vendors.title')
            ->orderByDesc('sum_delay_time')
            ->get();
    }
}
