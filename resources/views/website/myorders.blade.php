@extends('layouts.website')
@section('body')


    <!-- Page Content -->
    <div class="page-heading page-heading-auth contact-heading header-text" style="background-image: url(public/assets/images/contact_banner.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h2>My Orders</h2>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="products call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Hi, {{ ucfirst(Auth::guard('customer')->user()->name) }}</h2>
                        <h4>Your Orders</h4>
                    </div>
                </div>
                
                
                <div class="col-md-12">
                    
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th width="30%">Invoice Number</th>
                                <th width="15%">Payment Status</th>
                                <th width="15%">Total Amount</th>
                                <th width="20%">Order Date</th>
                                <th width="15%">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['user']->order as $orders)
                                <tr>
                                    <td>{{ $orders->invoice_number }}</td>
                                    @foreach($data['order_status'] as $status)
                                        @if($orders->payment_status == $status->id)
                                            <td>{{ $status->status }}</td>
                                        @endif
                                    @endforeach
                                    <td>&#8377;{{ $orders->order_final_amount }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($orders->created_at)) }}</td>
                                    @if($orders->payment_status == 2)
                                        <td>
                                            <a href="{{ route('customer.invoice', [$orders->id]) }}" class="btn btn-success btn-sm">Download Invoice</a>
                                        </td>
                                    @endif
                                    @if($orders->payment_status != 2)
                                        <td>
                                            Confirm Payment to Download Invoice
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection