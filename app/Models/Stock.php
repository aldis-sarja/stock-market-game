<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'company_name',
        'current_price',
        'change',
        'percent_change',
        'high_price',
        'low_price',
        'open_price',
        'previous_close_price',
        'last_change_time'
    ];
}
