<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'product_category_id',
        'name',
        'slug',
        'description',
        'featured',
        'available',
        'price',
        'discount',
        'gst_percentage'
    ];
    
    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }
    
    public function productCategory(){
        return $this->belongsTo(ProductCategory::class);
    }
    
    public function orderDetail(){
        return $this->hasMany(OrderDetail::class);
    }
}
