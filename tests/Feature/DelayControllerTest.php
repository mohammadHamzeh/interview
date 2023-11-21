<?php

namespace Tests\Feature;

use App\Enums\Trip\Status;
use App\Exceptions\DeliveryTimeIsNotPast;
use App\Exceptions\OrderDelivered;
use App\Models\DelayQueue;
use App\Models\DelayReport;
use App\Models\Order;
use App\Models\Trip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DelayControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function testDelayOrderWhenDeliveryTimeIsNotPast(): void
    {
        $trip = Trip::factory()->create([
            'status' => Status::DELIVERED
        ]);
        $this->withoutExceptionHandling();

        $this->expectException(DeliveryTimeIsNotPast::class);
        $result = $this->post(route('order.delay'), [
            'order_id' => $trip->order_id
        ]);
    }

    public function testDelayOrderWhenOrderHasDeliveredTrip()
    {
        $order = Order::factory()->create([
            'delivery_time' => now()->subMinutes(10)
        ]);
        $trip = Trip::factory()->create([
            'order_id' => $order->id,
            'status' => Status::DELIVERED
        ]);

        $this->withoutExceptionHandling();

        $this->expectException(OrderDelivered::class);
        $result = $this->post(route('order.delay'), [
            'order_id' => $trip->order_id
        ]);
    }

    public function testDelayOrderWhenOrderHasAssignedTrip()
    {
        $order = Order::factory()->create([
            'delivery_time' => now()->subMinutes(10)
        ]);
        $trip = Trip::factory()->create([
            'order_id' => $order->id,
            'status' => Status::ASSIGNED
        ]);

        $result = $this->post(route('order.delay'), [
            'order_id' => $trip->order_id
        ]);


        $this->assertDatabaseHas((new DelayReport())->getTable(), [
            'order_id' => $order->id,
        ]);

        $this->assertDatabaseHas((new Order())->getTable(), [
            'delivery_time' => $result->json('data.new_delivery_time')
        ]);

    }

    public function testDelayOrderWhenOrderNotHaveTrip()
    {
        $order = Order::factory()->create([
            'delivery_time' => now()->subMinutes(10)
        ]);

        $this->post(route('order.delay'), [
            'order_id' => $order->id
        ]);

        $this->assertDatabaseHas((new DelayReport())->getTable(), [
            'order_id' => $order->id,
            'delay_time' => null
        ]);

        $this->assertDatabaseHas((new DelayQueue())->getTable(), [
            'order_id' => $order->id,
            'agent_id' => null,
            'status' => \App\Enums\DelayQueue\Status::PENDING
        ]);
    }
}
