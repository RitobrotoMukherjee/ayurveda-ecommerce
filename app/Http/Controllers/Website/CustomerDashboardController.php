<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\BaseController;
use Auth;
use App\Models\Customer;
use App\Models\OrderStatus;

class CustomerDashboardController extends BaseController
{
    public function __construct(){
        Parent::__construct();
    }
    
    public function previousOrder(){
        $userId = Auth::guard('customer')->user()->id;
        $this->data['user'] = Customer::with(['order' => function($query){
            $query->orderBy('created_at', 'desc');
        }])->where('id', $userId)->first();
        
        $this->data['order_status'] = OrderStatus::get();
        
        return view('website.myorders', ['data' => $this->data]);
    }
}
