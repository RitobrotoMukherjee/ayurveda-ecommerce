@extends('layouts.admin')
@section('body')
@php

    $configure = [];        
    foreach($data['orders'] as $order){
        $viewLink = route('order.details', [$order->id]);
        $viewbtn = '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="View" href="'.$viewLink.'" target="_blank"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
        $configure[] = [$order->invoice_number, $order->order_total_amount, $order->order_discount, $order->tax_amount,$order->shipping_charge, $order->order_final_amount, $order->payment_type,
        '<nobr>'.$viewbtn.'</nobr>'];
    }
    
    //dd($configure);die;
    
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order Report</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Order Summary -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Order Summary</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Orders</span>
                                            <span class="info-box-number">{{ $data['count'] }}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                   <!-- /.info-box -->
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-rupee-sign"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Invoice Amount</span>
                                            <span class="info-box-number">{{ $data['total_invoice_amount'] }}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                   <!-- /.info-box -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-rupee-sign"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Shipping Charges</span>
                                            <span class="info-box-number">{{ $data['total_shipping'] }}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                   <!-- /.info-box -->
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box mb-3">
                                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-rupee-sign"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Tax Amount</span>
                                            <span class="info-box-number">{{ $data['total_tax'] }}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                   <!-- /.info-box -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!<!-- GST Report Table Data -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">GST Report Of Paid Invoice</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form role="form" id="order-add-edit" method="GET" action="{{ route('order.report') }}" >
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="from_date">From Date</label>
                                            <input type="text" class="form-control" id="from_date" placeholder="Select Date" name="from_date" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="to_date">To Date</label>
                                            <input type="text" class="form-control" id="to_date" placeholder="Select Date Bigger Than From Date" name="to_date" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <label for="from_date">--</label>
                                        <button type="submit" class="btn btn-warning btn-block">Get Report</button>
                                    </div>
                                </div>
                            </form>
                            <table id="order-list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Order MRP</th>
                                        <th>Discount</th>
                                        <th>Tax Amount</th>
                                        <th>Shipping Charge</th>
                                        <th>Order Final Amount</th>
                                        <th>Payment Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</div>
@endsection
@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd' })
            //Money Euro
            $('[data-mask]').inputmask()
            $('#order-list').DataTable( {
                "paging": true,
                "buttons": ["excel", "colvis"],
                "responsive": true,
                "ordering": false,
                "data": <?= json_encode($configure) ?>
            }).buttons().container().appendTo('#order-list_wrapper .col-md-6:eq(0)');;
        });
    </script>
@endsection