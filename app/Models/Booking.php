<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mobile', 'date', 'start_time', 'end_time', 'status', 'remark'];

    protected $casts = [
        'date' => 'date',
        'status' => 'boolean'
    ];
}
