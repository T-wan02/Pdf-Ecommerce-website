<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'img', 'price', 'buy_count'];
    protected $appends = ['file_url', 'img_url'];

    public function order()
    {
        return $this->belongsToMany(Order::class, 'product_orders');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function getFileUrlAttribute()
    {
        return asset('/storage/app/pdfs/' . $this->slug . '.pdf');
    }
    public function getImgUrlAttribute()
    {
        return asset('/assets/vendor/images/products/' . $this->img);
    }
}
