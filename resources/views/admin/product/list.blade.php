@extends('layouts.admin')
@section('body')
@php
    $btnDelete = '';

    $configure = [];           
    foreach($data['products'] as $product){
        $linkEdit = route('product.add-edit', [$product->id]);
        $linkDelete = route('product.delete', [$product->id]);
        $editbtn = '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="View/Edit" href="'.$linkEdit.'" target="_blank"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
        //$btnDelete = '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" href="'.$linkDelete.'" target="_blank"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
        $configure[] = [$product->id, $product->name, $product->available, '₹'.$product->price .' - ₹'. $product->discount, $product->productCategory->name, 
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
            <h1>Product List</h1>
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
                            <div class="col-6 pull-right">
                                <a class='btn btn-success btn-md card-title' href="{{ route('product.add-edit') }}" >Add Product</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="product-list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Available</th>
                                        <th>Price-Discount</th>
                                        <th>Product Category</th>
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
            $('#product-list').DataTable( {
                "paging": true,
                "buttons": ["excel", "print", "colvis"],
                "responsive": true,
                "ordering": false,
                "data": <?= json_encode($configure) ?>
            }).buttons().container().appendTo('#product-list_wrapper .col-md-6:eq(0)');;
        });
    </script>
@endsection