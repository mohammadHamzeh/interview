<?php

namespace Tests\Feature;

use App\Models\DelayReport;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatisticsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDelayedVendorHasOneDelayReport()
    {
        $delayReportOne = DelayReport::factory()->create();
        $delayReportTwo = DelayReport::factory()->create([
            'delay_time' => 60
        ]);

        $result = $this->get(route('statistics.delayed_vendor'));
        $result->assertJsonStructure([
            'data' => [
                [
                    'vendor_id',
                    'title',
                    'sum_delay_time'
                ]
            ]
        ]);

        $result->assertJson([
            'data' => [
                [
                    'vendor_id' => $delayReportOne->vendor_id,
                    'title' => $delayReportOne->vendor->title,
                    'sum_delay_time' => $delayReportOne->delay_time
                ],
                [
                    'vendor_id' => $delayReportTwo->vendor_id,
                    'title' => $delayReportTwo->vendor->title,
                    'sum_delay_time' => $delayReportTwo->delay_time
                ],
            ]
        ]);
    }

    public function testDelayedReportVendorWhenOneVendorHasTwoDelayReport()
    {
        $vendor = Vendor::factory()->create();
        $delayReportOne = DelayReport::factory()->create([
            'vendor_id' => $vendor->id,
        ]);
        $delayReportTwo = DelayReport::factory()->create([
            'vendor_id' => $vendor->id,
            'delay_time' => 80
        ]);
        $delayReportThree = DelayReport::factory()->create([
            'delay_time' => 60
        ]);

        $result = $this->get(route('statistics.delayed_vendor'));
        $result->assertJsonStructure([
            'data' => [
                [
                    'vendor_id',
                    'title',
                    'sum_delay_time'
                ]
            ]
        ]);

        $result->assertJson([
            'data' => [
                [
                    'vendor_id' => $delayReportOne->vendor_id,
                    'title' => $delayReportOne->vendor->title,
                    'sum_delay_time' => $delayReportOne->delay_time+$delayReportTwo->delay_time
                ],
                [
                    'vendor_id' => $delayReportThree->vendor_id,
                    'title' => $delayReportThree->vendor->title,
                    'sum_delay_time' => $delayReportThree->delay_time
                ],
            ]
        ]);
    }
}