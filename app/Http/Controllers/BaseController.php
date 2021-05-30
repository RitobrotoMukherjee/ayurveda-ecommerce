<?php

namespace App\Http\Controllers;
use App\Models\ProductCategory;

class BaseController extends Controller
{
    protected $data; // all data to be passed to view
    public function __construct(){
        $this->data['cart_count'] = 0;
        $this->data['device'] = 'pc';
        if($this->isMobileDevice()){
            $this->data['device'] = 'mobile';
        }
        
        $this->data['product_categories'] = ProductCategory::get();
    }
    
    protected function getDateTime(){
        
        $data['date_time'] = date('Y-m-d H:i:s');
        $data['date'] = date('Y-m-d');
        
        return $data;
    }
    
    protected function isMobileDevice(){
//        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);

    }
}
