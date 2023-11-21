<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DelayQueue extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'order_id',
        'agent_id',
        'status'
    ];

    public function order(): BelongsTo
    {
            return $this->belongsTo(Order::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }
}
