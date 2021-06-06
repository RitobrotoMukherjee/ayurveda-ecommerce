<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id',
        'customer_id',
        'order_status_id',
        'invoice_number',
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'customer_mobile',
        'delivery_address_1',
        'delivery_address_2',
        'delivery_city',
        'delivery_district',
        'delivery_state',
        'delivery_pincode',
        'total_quantity',
        'order_total_amount',
        'order_discount',
        'tax_amount',
        'order_final_amount',
        'payment_type',
        'payment_status',
        'payment_gateway',
        'txn_id',
        'payment_response',
        'despatched_at',
        'delivered_at'
    ];
    
    public function orderDetail(){
        return $this->hasMany(OrderDetail::class);
    }
    
    public function orderStatus(){
        return $this->belongsTo(OrderStatus::class);
    }
    
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
