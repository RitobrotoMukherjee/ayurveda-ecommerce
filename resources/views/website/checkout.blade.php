@extends('layouts.website')
@section('body')

    <div class="find-us">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="section-heading">
                        <h2>Pay Using UPI</h2>
                        <h4>{{ config('app.upi') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="happy-clients">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row text-center">
                        <img src="{{ config('app.asset_url') }}/assets/images/payments/GooglePay.jpg" alt="">
                    </div>
                    <div class="row text-center"><h4>Pay Using Gpay</h4></div>
                </div>
                <div class="col-md-6">
                    <div class="row  text-center">
                        <img src="{{ config('app.asset_url') }}/assets/images/payments/PhonePay.jpg" alt="">
                    </div>
                    <div class="row text-center"><h4>Pay Using PhonePe</h4></div>
                </div>
            </div>
        </div>
    </div>
@endsection