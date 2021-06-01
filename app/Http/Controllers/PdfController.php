<?php

namespace App\Http\Controllers;

use App\Models\Order;
use PDF;

class PdfController extends BaseController
{
    public function __construct() {
        parent::__construct();
    }
    
    public function generatePdf($orderId) {
        
        $order = Order::with('orderDetail.product')->where('id', $orderId)->first();
//        dd($order->toArray());
        $data = [
            'invoice_number' => $order->invoice_number,
            'invoice_date' => date('d/m/Y H:i',strtotime($order->created_at)),
            'customer_name' => $order->customer_first_name.' '.$order->customer_last_name,
            'delivery_address_1' => $order->delivery_address_1,
            'delivery_address_2' => $order->delivery_address_2,
            'address_last' => $order->delivery_city.', '.$order->delivery_state,
            'pin' => $order->delivery_pincode,
            'description' => $order->orderDetail,
            'subtotal' => $order->order_final_amount
        ];
        
        $pdf = PDF::loadView('orderPDF', $data);
    
        return $pdf->download($order->invoice_number.'.pdf');
    }
}