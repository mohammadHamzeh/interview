<?php

namespace Database\Factories;

use App\Enums\DelayQueue\Status;
use App\Models\Agent;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DelayQueue>
 */
class DelayQueueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'agent_id' => Agent::factory(),
            'status' => $this->faker->randomElement(Status::VALUES),
        ];
    }
}
