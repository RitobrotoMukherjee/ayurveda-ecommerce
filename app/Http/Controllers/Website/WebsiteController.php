<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\BaseController;
use App\Models\Product;

class WebsiteController extends BaseController
{
    
    public function __construct(){
        Parent::__construct();
    }
    
    public function home() {
        $this->data['page'] = 'home';
        
        $this->data['products'] = Product::where('featured', 1)->get();
        
//        dd($this->data);
        return view('website.home', ['data' => $this->data]);
    }
    
    public function contact(){
        return view('website.contact', ['data' => $this->data]);
    }
    
    public function about(){
        return view('website.about', ['data' => $this->data]);
    }
    
//    public function dashboard(){
//        // if customer dashboard comes in, can be designed under this
//        return view ('website.customer_dashboard');
//    }
}
