<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Order;


class AdminController extends BaseController
{
    public function __construct() {
        Parent::__construct();
    }
    
    public function dashboard() {
        $fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
        $tillDate = Carbon::now()->subDay()->endOfWeek()->toDateString();
        
        $this->data['orders_week'] = Order::whereBetween( DB::raw('date(created_at)'), [$fromDate, $tillDate] )->get()->count();
        
        $this->data['total_orders'] = Order::get()->count();
        
        $this->data['orders_month'] = Order::whereMonth('created_at', date('m'))->get()->count();
        
        $this->data['orders_today'] = Order::whereDate('created_at', Carbon::today())->get()->count();
        
        return view('admin.dashboard', ['data' => $this->data]);
    }
}
