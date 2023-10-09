<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname', 'lname', 'email', 'address', 'country', 'postal_code', 'city', 'state', 'phone_number',
        'cartToken', 'order_confirmed_time', 'order_confirmed_date', 'order_confirm',
        'sub_total', 'tax', 'total'
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_orders');
    }
}
