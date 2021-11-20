<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
