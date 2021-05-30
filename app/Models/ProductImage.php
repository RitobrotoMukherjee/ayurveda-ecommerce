<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'id',
        'product_id',
        'image_name',
        'image_path',
        'image_size',
        'image_extension',
        'image_type',
    ];
    
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
