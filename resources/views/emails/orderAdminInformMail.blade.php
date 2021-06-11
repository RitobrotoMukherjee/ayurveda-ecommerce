@component('mail::message')
Invoice Number - {{ $mail->invoice_number }}

Preferred payment method is {{ strtoupper($mail->payment_type) }}.<br>
Order Amount &#8377; {{ $mail->order_final_amount }}.
Please add shipping charges for the order to be payment ready.


@component('mail::panel')
For details check Admin Panel with {{ $mail->invoice_number }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
