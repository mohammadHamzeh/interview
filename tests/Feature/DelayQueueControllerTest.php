<?php

namespace Tests\Feature;

use App\Enums\DelayQueue\Status;
use App\Exceptions\AgentHasPendingDelayedQueue;
use App\Exceptions\DelayedQueueEmpty;
use App\Models\Agent;
use App\Models\DelayQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DelayQueueControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testDelayQueueWhenAgentIsAvailable(): void
    {
        $agent = Agent::factory()->create();

        $delayQueue = DelayQueue::factory()->create([
            'agent_id' => null,
            'status' => Status::PENDING
        ]);
        $order = $delayQueue->order;

        $result = $this->post(route('delayQueue.pick_delay_queue'), [
            'agent_id' => $agent->id
        ]);


        $result->assertJsonStructure([
            'data' => [
                'id',
                'order' => [
                    'id',
                    'vendor_id',
                    'delivery_time',
                    'created_at',
                    'updated_at'
                ],
                'agent' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at'
                ],
                'created_at'
            ]
        ]);
    }

    public function testDelayQueueWhenAgentNotAvailable(): void
    {
        $agent = Agent::factory()->create();

        $delayQueue = DelayQueue::factory()->create([
            'agent_id' => $agent->id,
            'status' => Status::PENDING
        ]);
        $this->withoutExceptionHandling();

        $this->expectException(AgentHasPendingDelayedQueue::class);
        $result = $this->post(route('delayQueue.pick_delay_queue'), [
            'agent_id' => $agent->id
        ]);
    }

    public function testDelayQueueWhenDelayedQueueIsEmpty(): void
    {
        $agent = Agent::factory()->create();

        $this->withoutExceptionHandling();
        $this->expectException(DelayedQueueEmpty::class);

        $this->post(route('delayQueue.pick_delay_queue'), [
            'agent_id' => $agent->id
        ]);
    }


}
