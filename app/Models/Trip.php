<?php

namespace App\Models;

use App\Enums\Trip\Status;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Status $status
 */
class Trip extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'order_id',
        'status'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
