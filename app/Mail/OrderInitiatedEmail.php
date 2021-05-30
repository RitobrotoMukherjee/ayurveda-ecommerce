<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderInitiatedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        dd($this->order);
        return $this->subject('SKAP Order Initiated')
                ->from('orders@skap.online')
                ->markdown('emails.orderInitiatedMail')
                ->with('mail', $this->order);
    }
}
