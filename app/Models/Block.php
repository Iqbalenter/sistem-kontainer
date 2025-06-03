<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Block extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'capacity',
        'status'
    ];

    protected $casts = [
        'is_full' => 'boolean',
        'current_capacity' => 'integer',
        'max_capacity' => 'integer'
    ];

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
} 