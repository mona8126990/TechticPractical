<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'voucher_id',
        'total_amount',
        'discount_amount',
        'grand_total_amount',
    ];

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class,'order_id','id');
    }
}
