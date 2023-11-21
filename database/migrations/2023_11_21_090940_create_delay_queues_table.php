<?php

use App\Enums\DelayQueue\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Status::up();
        Schema::create('delay_queues', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('order_id')->constrained();
            $table->foreignUlid('agent_id')->nullable()->constrained();
            $table->addColumn('delayQueueStatus', 'status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delay_queues');
        Status::down();
    }
};
