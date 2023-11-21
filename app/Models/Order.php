<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property Trip $trip
 * @property string $vendor_id
 * @property mixed $id
 * @property mixed $delivery_time
 */
class Order extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'vendor_id',
        'delivery_time'
    ];

    protected $casts = [
        'delivery_time' => 'datetime'
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function trip(): HasOne
    {
        return $this->hasOne(Trip::class);
    }

    public function delayReports(): HasMany
    {
        return $this->hasMany(DelayReport::class);
    }

    public function delayQueue(): HasMany
    {
        return $this->hasMany(DelayQueue::class);
    }

    public function isPastDeliveryTime(): bool
    {
        return $this->delivery_time->isPast();
    }
}
