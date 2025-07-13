<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retrieval extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'container_number',
        'container_name',
        'license_plate',
        'retrieval_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'retrieval_date' => 'date'
    ];
}
