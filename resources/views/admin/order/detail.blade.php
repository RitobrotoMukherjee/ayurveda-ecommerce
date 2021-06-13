@extends('layouts.admin')
@section('body')

@php
    $featureds = ['No','Yes'];
    $id = $data['order_detail']->id ?? '';
    //dd(request()->session()->get('error'));
@endphp

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                   <h1>Order Detail</h1>
                </div>
          
              	@if(isset($data['order_detail']->order_status_id) && ($data['order_detail']->order_status_id == 3))
                    <div class="col-sm-5 offset-sm-1">
                        <a class="btn btn-success" href='{{ route('admin.download.pdf', [$id]) }}'>Download Invoice</a>
                    </div>
                @endif
                
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <!-- Order Update Form -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Update Order Status</h3>
                        </div>
                    
                        <form role="form" id="order-add-edit" method="POST" action="{{ route('order.update', [$data['order_detail']]) }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" class="form-control" id="order-id" name="order[id]" value="{{ $data['order_detail']->id ?? old('order.id') }}">
                            <input type="hidden" class="form-control" id="order-amount" name="order[order_final_amount]" value="{{ $data['order_detail']->order_final_amount ?? old('order.order_final_amount') }}">

                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="orderStatus">Select Status</label>
                                        <select class="form-control" id="orderStatus" name="order[order_status_id]" required>
                                            <option value=''>Please select from list</option>
                                            @foreach($data['order_status'] as $status)
                                                @if(isset($data['order_detail']->order_status_id) && ($data['order_detail']->order_status_id == 1) && ($status->id == 3))
                                                    @php
                                                        continue;
                                                    @endphp
                                                @endif
                                                <option value='{{ $status->id }}' {{ (isset($data['order_detail']->order_status_id) && ($data['order_detail']->order_status_id == $status->id)) ? 'selected' : old('order.order_status_id')}}>{{ $status->status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="transaction_id">Transaction Id using {{ strtoupper($data['order_detail']->payment_type) }}</label>
                                            <input type="text" class="form-control" id="transaction_id" placeholder="Transaction ID" name="order[txn_id]" value="{{ $data['order_detail']->txn_id ?? old('order.txn_id') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shipping_charges">Shipping Charges</label>
                                            <input type="text" class="form-control" id="shipping_charges" placeholder="Shipping Charges" name="order[shipping_charge]" value="{{ $data['order_detail']->shipping_charge ?? old('order.shipping_charge') }}" required>
                                        </div>
                                    </div>
                                </div>
                                @if($data['order_detail']->order_status_id != 3)
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3 text-center">
                                            @if($id == '')
                                            <button type="submit" class="btn btn-warning btn-block">Save</button>
                                            @else
                                            <button type="submit" class="btn btn-warning btn-block">Update</button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Order Update Form end -->
            
            <!-- Order details -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-text-width"></i>
                                Order Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <dl>
                                <div class="row">
                                    <div class="col-md-8">
                                        <dt>Invoice Number</dt>
                                        <dd>{{ $data['order_detail']->invoice_number }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <dt>Qty</dt>
                                        <dd>{{ $data['order_detail']->total_quantity }}</dd>
                                    </div>
                                    <div class="col-md-4">
                                        <dt>Amount</dt>
                                        <dd>{{ $data['order_detail']->order_total_amount }}</dd>
                                    </div>
                                    <div class="col-md-4">
                                        <dt>Discount</dt>
                                        <dd>{{ $data['order_detail']->order_discount }}</dd>
                                    </div>
                                    <div class="col-md-4">
                                        <dt>Tax Amount</dt>
                                        <dd>{{ $data['order_detail']->tax_amount }}</dd>
                                    </div>
                                    <div class="col-md-4">
                                        <dt>Final Amount(inc shipping)</dt>
                                        <dd>{{ $data['order_detail']->order_final_amount }}</dd>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <dt >Delivery Details</dt>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <dt>Customer First Name</dt>
                                        <dd>{{ $data['order_detail']->customer_first_name }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt>Customer Last Name</dt>
                                        <dd>{{ $data['order_detail']->customer_last_name }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <dt>Customer Email</dt>
                                        <dd>{{ $data['order_detail']->customer_email }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt>Customer Phone Number</dt>
                                        <dd>{{ $data['order_detail']->customer_mobile }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <dt>Shipping address Line-1</dt>
                                        <dd>{{ $data['order_detail']->delivery_address_1 }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt>Shipping Address Line-2</dt>
                                        <dd>{{ $data['order_detail']->delivery_address_2 }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <dt>Shipping City</dt>
                                        <dd>{{ $data['order_detail']->delivery_city }}</dd>
                                    </div>
                                    <div class="col-md-4">
                                        <dt>Shipping State</dt>
                                        <dd>{{ $data['order_detail']->delivery_state }}</dd>
                                    </div>
                                    <div class="col-md-4">
                                        <dt>Shipping Pin</dt>
                                        <dd>{{ $data['order_detail']->delivery_pincode }}</dd>
                                    </div>
                                </div>
                            </dl>
                        </div>
                          <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- Order details End-->
            
            <!-- Order Break Ups -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-text-width"></i>
                                Order Break Ups
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th colspan="2">Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>GST</th>
                                        <th>Final Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['order_detail']->orderDetail as $order)
                                        <tr>
                                            <td colspan="2">{{ $order->product->name }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>{{ $order->price }}</td>
                                            <td>{{ $order->discount }}</td>
                                            <td>{{ $order->gst_percentage }}%</td>
                                            <td><span class="tag tag-success">{{ $order->final_price }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                          <!-- /.card-body -->
                    </div>
                </div>
            </div>
            
            <!-- Order Break Ups End-->
        </div>
    </section>
</div>

    
@stop

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/css/admin_custom.css') }}">
@stop

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){          
            $("#order-add-edit").validate({
                rules:{
                    "order[order_status_id]": {
                        required: true,
                    },
                    "order[txn_id]":{
                        required:true,
                    },
                    "order[shipping_charge]":{
                        required:true,
                        number: true
                    }
                }
            });
            @if(request()->session()->get('error'))
                toastr.error("<?=request()->session()->get('error')?>");
            @endif
            @if(request()->session()->get('successful'))
                toastr.success("<?=request()->session()->get('successful')?>");
            @endif
        });
    </script>
@stop