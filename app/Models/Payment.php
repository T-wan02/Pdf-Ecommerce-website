<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'name',
        'transaction_id', 'status', 'card_last_four', 'card_brand', 'currency',
        'total', 'giving_date'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
