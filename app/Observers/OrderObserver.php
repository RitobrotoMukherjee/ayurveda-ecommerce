<?php

namespace App\Observers;

use App\Models\Order;
use App\Mail\OrderInitiatedEmail;
use App\Mail\OrderAdminInform;
use App\Mail\OrderInvoiceRaisedEmail;
use App\Mail\OrderInvoicePaidEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    protected $adminEmail;
    
    public function __construct() {
        $this->adminEmail = "ritobrotomukherjee1991@gmail.com";
    }
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        $order->invoice_number = 'SKAP-'.uniqid().'-'.$order->id;
        $order->save();
        Log::stack(['single'])->info('Sending email order initiation mail to '. $order->customer_email.', '.$this->adminEmail);
        Mail::to($order->customer_email)->queue(new OrderInitiatedEmail($order));
        Mail::to($this->adminEmail)->queue(new OrderAdminInform($order));
//        Mail::to("sreekrishnaayurvedicpharmacy@gmail.com")->queue(new OrderAdminInform($order));
    }
    /**
     * Handle the Order "updating" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updating(Order $order)
    {
        
    }
    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        if($order->wasChanged('order_status_id') && $order->order_status_id == 2){
            Mail::to($order->customer_email)->queue(new OrderInvoiceRaisedEmail($order));
        }
        
        if($order->wasChanged('order_status_id') && $order->order_status_id == 3){
            Mail::to($order->customer_email)->queue(new OrderInvoicePaidEmail($order));
        }
        
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
