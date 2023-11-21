<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;
    use HasUlids;
    protected $fillable = [
        'title'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
