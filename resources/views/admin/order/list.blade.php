@extends('layouts.admin')
@section('body')
@php

    $configure = [];        
    foreach($data['orders'] as $order){
        $linkEdit = route('order.details', [$order->id]);
        $editbtn = '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="View/Edit" href="'.$linkEdit.'" target="_blank"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
        $configure[] = [$order->invoice_number, $order->customer_first_name, $order->order_final_amount, $order->payment_type,$order->orderStatus->status,
        '<nobr>'.$editbtn.'</nobr>'];
    }
    
    //dd($configure);die;
    
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order List</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Check Your Orders and Invoices</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="order-list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Customer First Name</th>
                                        <th>Order Amount</th>
                                        <th>Payment Type</th>
                                        <th>Order Status</th>
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
            $('#order-list').DataTable( {
                "paging": true,
                "buttons": ["excel", "print", "colvis"],
                "responsive": true,
                "ordering": false,
                "data": <?= json_encode($configure) ?>
            }).buttons().container().appendTo('#order-list_wrapper .col-md-6:eq(0)');;
        });
    </script>
@endsection