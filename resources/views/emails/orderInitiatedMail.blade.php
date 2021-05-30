@component('mail::message')
Invoice Number - {{ $mail->invoice_number }}

Your Preferred payment method is {{ strtoupper($mail->payment_type) }}.<br>
Your Order Has Been Initiated. Please pay &#8377; {{ $mail->order_final_amount }} to confirm order.

@component('mail::panel')
SKAP-UPI - {{ config('app.upi') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
