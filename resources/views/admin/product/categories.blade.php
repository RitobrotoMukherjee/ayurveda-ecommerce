@extends('layouts.admin')
@section('body')
@php

$configure = [];           
foreach($data['product_categories'] as $product_category){
    $linkEdit = route('product.category', [$product_category->id]);
    $btnEdit = '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="View/Edit" href="'.$linkEdit.'" target="_blank"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
    $configure[] = [$product_category->id, $product_category->name, '<nobr>'.$btnEdit.'</nobr>'];
}
//print_r($configure);die;
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Category List</h1>
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
                                <a class='btn btn-success btn-md card-title' href="{{ route('product.category') }}" >Add Product Category</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="product-categories" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
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
    
@stop
@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('#product-categories').DataTable( {
                "paging": true,
                "buttons": ["excel", "print"],
                "responsive": true,
                "ordering": false,
                "data": <?= json_encode($configure) ?>
            }).buttons().container().appendTo('#product-categories_wrapper .col-md-6:eq(0)');;
        });
    </script>
@stop