@component('mail::message')
Invoice Number For Further Contact - {{ $mail->invoice_number }}

Your Preferred payment method is {{ strtoupper($mail->payment_type) }}.<br>
You have paid total &#8377; {{ $mail->order_final_amount }} .<br>

@component('mail::panel')
You can download invoice in MyOrder section of your account.
@endcomponent

SKAP-Contact - <a href="tel:{{ config('app.contact') }}" target="_top">{{ config('app.contact') }}</a><br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
