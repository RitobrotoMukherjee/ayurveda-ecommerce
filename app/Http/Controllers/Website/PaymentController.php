<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Validator;

class PaymentController extends BaseController
{
    public function __construct(){
        Parent::__construct();
    }
    
    public function checkout(Request $request){
//        dd($request->input('order'));
        $inputs = $request->input('order');
        
        $validator = $this->validationResponse($inputs);
        if ($validator->passes()) {
            $order = $this->saveOrders($inputs);
            if(isset($order->id)){
                $orderdetails = $this->saveOrderDetails($order, $inputs['order_details']);
                if(isset($orderdetails)){
                    session()->forget('cart');
                    return view('website.checkout', ['data' => $this->data]);
                }
            }
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        return redirect()->back()->with('error', 'Order not saved, Contact support team');
    }
    
    public function pay(){
        return view('website.pay', ['data' => $this->data]);
    }
    
    protected function validationResponse($input){
        $validations = [
            "order_details" => 'required|json', 'customer_first_name' => 'required|max:25', 'customer_last_name' => 'required|max:25',
            'customer_email' => 'required|email', 'customer_mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10', 'delivery_address_1' => 'required|max:150',
            'delivery_city' => 'required|string|max:20', 'delivery_state' => 'required|string|max:30', 'delivery_pincode' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:5',
            'payment_type' => 'required'
        ];
        return Validator::make($input, $validations);
    }
    
    private function saveOrders($inputs){
        $orderDetailsInput = json_decode($inputs['order_details'], true);
        $amounts = $this->getAmounts($orderDetailsInput);
        $total_quantity = (int)$this->getQty($orderDetailsInput);
        $orderArr = [
            'customer_id' => $inputs['customer_id'], 'order_status_id' => 1, 'customer_first_name' => $inputs['customer_first_name'],'customer_last_name' => $inputs['customer_last_name'],
            'customer_email' => $inputs['customer_email'], 'customer_mobile' => $inputs['customer_mobile'], 'delivery_address_1' => $inputs['delivery_address_1'],'delivery_address_2' => $inputs['delivery_address_2'] ?? '',
            'delivery_city' => $inputs['delivery_city'], 'delivery_state' => $inputs['delivery_state'], 'delivery_pincode' => $inputs['delivery_pincode'],
            'payment_type' => $inputs['payment_type'], 'payment_status' => 1, 'total_quantity' => $total_quantity,
            'order_total_amount' => $amounts['order_total_amount'], 'order_discount' => $amounts['order_discount'],'tax_amount' => $amounts['tax_amount'], 
            'order_final_amount' => $amounts['order_total_amount'] + $amounts['tax_amount'] - $amounts['order_discount']
        ];
//        dd($orderArr);
        $order = Order::create($orderArr);
        /*
         * Order observer
         */
        
        return $order;
    }
    
    private function saveOrderDetails($order, $inputs) {
        $orderDetailsInput = json_decode($inputs, true);
        $orderDetails = null;
        
        foreach($orderDetailsInput as $id => $dtl){
            $orderDtl = new OrderDetail();
            $orderDtl->order_id = $order->id;
            $orderDtl->product_id = $id;
            $orderDtl->quantity = $dtl['quantity'];
            $orderDtl->price = $dtl['price']*$dtl['quantity'];
            $orderDtl->discount = $dtl['discount']*$dtl['quantity'];
            $orderDtl->gst_percentage = $dtl['gst_percentage'];
            $tax = (($orderDtl->price-$orderDtl->discount) * $orderDtl->gst_percentage)/100;
            $orderDtl->final_price = $orderDtl->price+ $tax -$orderDtl->discount;
            $orderDetails = $orderDtl->save();
        }
        return $orderDetails;
    }
    
    private function getAmounts($order_details){
        $return=['order_total_amount' => 0, 'order_discount' => 0,'tax_amount' => 0 ];
        foreach($order_details as $id => $v){
            $return['order_total_amount'] += $v['price']*$v['quantity'];
            $return['order_discount'] += $v['discount']*$v['quantity'];
            $prd_price = (($v['price']-$v['discount'])* $v['quantity']);
            $return['tax_amount'] += ($prd_price * $v['gst_percentage'])/100;
        }
        return $return;
    }
    
    private function getQty($order_details){
        
        $return = 0;
        foreach($order_details as $v){
            $return += $v['quantity'];
        }
        return $return;
    }
}
