<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stock_id',
        'symbol',
        'price',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
