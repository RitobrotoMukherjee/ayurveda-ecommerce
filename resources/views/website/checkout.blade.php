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
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ config('app.asset_url') }}/assets/images/payments/GooglePay.jpg" width="250" height="350" alt="">
                            <h4>Pay Using Gpay</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ config('app.asset_url') }}/assets/images/payments/PhonePay.jpg" width="250" height="350" alt="">
                            <h4>Pay Using PhonePe</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection