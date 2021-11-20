<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_amount',
    ];

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
