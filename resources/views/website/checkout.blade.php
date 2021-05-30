@extends('layouts.website')
@section('body')


    <!-- Page Content -->
    <div class="page-heading contact-heading header-text" style="background-image: url(public/assets/images/contact_banner.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h2>Check Out</h2>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="find-us">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Pay Using UPI</h2>
              <h4>{{ config('app.upi') }}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    
@endsection