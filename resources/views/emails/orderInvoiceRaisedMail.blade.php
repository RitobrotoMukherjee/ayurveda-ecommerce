@component('mail::message')
Invoice Number For Further Contact - {{ $mail->invoice_number }}

Your Preferred payment method is {{ strtoupper($mail->payment_type) }}.<br>
We have added Shipping charges &#8377; {{ $mail->shipping_charge }} to your final amount. <br>
Please pay &#8377; {{ $mail->order_final_amount }} from your MyOrder section, to confirm the order.

@component('mail::panel')
Payment button is in MyOrder section of your account.
@endcomponent

SKAP-Contact - <a href="tel:{{ config('app.contact') }}" target="_top">{{ config('app.contact') }}</a><br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
