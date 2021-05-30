<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'status'
    ];
    public function order(){
        return $this->hasMany(Order::class);
    }
}
