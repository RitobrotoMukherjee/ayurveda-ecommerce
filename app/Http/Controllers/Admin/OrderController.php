<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderDetail;
use App\Models\Product;
use Validator;

class OrderController extends BaseController
{
    public function __construct() {
        Parent::__construct();
        $this->data['order_status'] = OrderStatus::get();
    }
    
    public function orderList(){
        $this->data['orders'] = Order::with(['orderStatus'])->orderBy('id', 'desc')->get();
        return view('admin.order.list', ['data' => $this->data]);
    }
    
    public function gstReport(Request $request){
        $inputs = $request->all();
        $to = date('Y-m-d');
        $from = date('Y-m-d',strtotime("-1 days"));
        if(isset($inputs['to_date']) && $inputs['to_date'] != ""){
            $to = date('Y-m-d', strtotime($inputs['to_date']));
        }
        if(isset($inputs['from_date']) && $inputs['from_date'] != ""){
            $from = date('Y-m-d', strtotime($inputs['from_date']));
        }
        $collection = Order::select(['id','invoice_number','order_total_amount', 'order_discount', 'tax_amount', 'shipping_charge', 'order_final_amount', 'payment_type'])
                ->where('payment_status', 2)->whereBetween('created_at', [$from." 00:00:00", $to." 23:59:59"])->orderBy('id', 'desc')->get();
        
        $this->data['orders'] = $collection;
        
        $this->data['count'] = $collection->count();
        $this->data['total_tax'] = $collection->sum('tax_amount');
        $this->data['total_shipping'] = $collection->sum('shipping_charge');
        $this->data['total_invoice_amount'] = $collection->sum('order_final_amount');
        
        return view('admin.order.gst_report', ['data' => $this->data]);
    }
    
    public function getOrderById($id=""){
        if(isset($id) && $id > 0){
            $this->data['order_detail'] = Order::with(['orderStatus','customer', 'orderDetail.product'])->where('id', $id)->first();
        }
        return view('admin.order.detail', ['data' => $this->data]);
    }
    
    public function updateOrder(Order $order,Request $request){
        $inputs = $request->input('order');
        $validator = $this->validateResponse($inputs);
        if ($validator->passes()) {
            $order->order_status_id = $inputs['order_status_id'];
            $order->payment_status = $inputs['order_status_id'];
            $order->txn_id = $inputs['txn_id'];
            $order->shipping_charge = $inputs['shipping_charge'];
            if($order->isDirty('order_status_id') && $order->order_status_id == 2){
                $order->order_final_amount = $this->calculateFinalAmount($inputs);
                $prodUpdate = $this->updateProduct($order);
                if($prodUpdate){ $order->save(); }
                if(!$prodUpdate){
                    return redirect()->route('order.details', [$order->id])->with('error','Cannot raise invoice '.$order->invoice_number. ', Product Not Available in inventory. Please add product to mark as paid');
                }
            }
            if($order->order_status_id != 2){
                $order->save();
            }
            
            return redirect()->route('order.details', [$order->id] )->with('successful', 'Order Updated '.$order->invoice_number);
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        return redirect()->back()->with('error', 'Order not saved, Contact support team');
    }
    
    public function orderStatusList() {
        
    }
    
    protected function validateResponse($input){
        $validations = [
            "order_status_id" => 'required|integer', 'txn_id' => 'required|string|max:50',
            "shipping_charge" => 'required|integer'
            ];
        return Validator::make($input, $validations);
    }
    
    private function updateProduct($orderObj){
        $return = false;
        $orderDtl = OrderDetail::where('order_id', $orderObj->id)->get();
        $products = [];
        $ids = [];
        $avl = [];
        foreach($orderDtl as $dtl){
            $products[$dtl->product_id] = $dtl->quantity;
            $ids[] = $dtl->product_id;
        }
        $prod_obj = Product::whereIn('id', $ids)->get();
        foreach($prod_obj as $prod){
            $avl[$prod->id] = $prod->available - $products[$prod->id];
        }
        $avls = $this->arrayCheck($avl);
        if($avls){
            $return = true;
            foreach($prod_obj as $prod){
                $prod->available = $prod->available - $products[$prod->id];
                if($prod->available >= 0){
                    $prod->save();
                }
            }
        }
        return $return;
    }
    
    private function arrayCheck($arr){
        $return = true;
        foreach($arr as $v){
            if($v < 0){
                $return = false;
            }
        }
        return $return;
    }
    
    private function calculateFinalAmount($inputs) {
        return $inputs['order_final_amount'] + $inputs['shipping_charge'];
    }
    
}
