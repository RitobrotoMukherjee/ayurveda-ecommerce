@component('mail::message')
Invoice Number For Further Contact - {{ $mail->invoice_number }}

Your Preferred payment method is {{ strtoupper($mail->payment_type) }}.<br>
Your Order Has Been Initiated. We are calculating Shipping charges. <br>
Order Amount without shipping charges &#8377; {{ $mail->order_final_amount }}.

@component('mail::panel')
SKAP-Contact - <a href="tel:{{ config('app.contact') }}" target="_top">{{ config('app.contact') }}</a>
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
