<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'ordered_quantity',
        'order_price',
        'order_discount',
        'order_final_price'
    ];
    
    public function order(){
        return $this->belongsTo(Order::class);
    }
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
