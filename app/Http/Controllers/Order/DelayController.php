<?php

namespace App\Http\Controllers\Order;

use App\Contracts\Repository\DelayQueueRepository;
use App\Contracts\Repository\DelayReportRepository;
use App\Contracts\Repository\OrderRepository;
use App\Enums\Trip\Status;
use App\Exceptions\DeliveryTimeIsNotPast;
use App\Exceptions\OrderDelivered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\DelayRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DelayController extends Controller
{
    public function __construct(
        private readonly OrderRepository       $orderRepository,
        private readonly DelayReportRepository $delayReportRepository,
        private readonly DelayQueueRepository  $delayQueueRepository
    )
    {
    }

    public function delay(DelayRequest $request): JsonResponse
    {
        /** @var Order $order */
        $order = $this->orderRepository->find($request->getOrderId(), ['trip']);
        $trip = $order->trip;

        throw_unless($order->isPastDeliveryTime(), DeliveryTimeIsNotPast::class);
        throw_if((!empty($trip) && $trip->status == Status::DELIVERED), OrderDelivered::class);

        if ($this->isTripValid($trip)) {
            $deliveryTime = $this->fetchDeliveryTime();

            DB::transaction(function () use ($order, $deliveryTime) {
                $this->updateOrderDeliveryTime($order, $deliveryTime);
                $this->storeDelayReports($order, $deliveryTime);
            });

            return response()->json([
                'data' => [
                    'new_delivery_time' => now()->addMinutes($deliveryTime)->toIso8601String()
                ]
            ]);
        } else {
            $this->processInvalidTrip($order);
            // todo change message and read from translate files
            return response()->json([
                'data' => [
                    'message' => 'سفارش در دست بررسی'
                ]
            ]);
        }
    }

    private function storeDelayReports(Order $order, int $deliveryTime = null): void
    {
        $this->delayReportRepository->create([
            'order_id' => $order->id,
            'vendor_id' => $order->vendor_id,
            'delay_time' => $deliveryTime
        ]);
    }

    private function isTripValid($trip): bool
    {
        return !empty($trip) && in_array($trip->status, [Status::ASSIGNED, Status::AT_VENDOR, Status::PICKED]);
    }

    private function fetchDeliveryTime()
    {
        $result = Http::get('https://run.mocky.io/v3/122c2796-5df4-461c-ab75-87c1192b17f7');
        return $result->json('time');
    }

    private function updateOrderDeliveryTime($order, $deliveryTime): void
    {
        $this->orderRepository->update([
            'delivery_time' => now()->addMinutes($deliveryTime)
        ], $order->id);
    }

    private function processInvalidTrip($order): void
    {
        DB::transaction(function () use ($order) {
            $this->storeDelayReports($order);
            $this->delayQueueRepository->create([
                'order_id' => $order->id,
                'status' => \App\Enums\DelayQueue\Status::PENDING
            ]);
        });
    }

}
