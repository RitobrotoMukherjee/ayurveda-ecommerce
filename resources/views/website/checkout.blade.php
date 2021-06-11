@extends('layouts.website')
@section('body')

    <div class="find-us">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="section-heading">
                        <h2>Your Order Has Been Initiated</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="happy-clients">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 text-center">
                    <div class="row ">
                        <h5>Our Team Is Calculating the Shipping Charges.</h5>
                        <h6>You will get update via mail soon.</h6><br>
                        <h5>In case of any query contact us <a href="tel:{{ config('app.contact') }}" target="_top">{{ config('app.contact') }}</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection