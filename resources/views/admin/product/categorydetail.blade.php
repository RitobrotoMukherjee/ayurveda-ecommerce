@extends('layouts.admin')
@section('body')

@php
    $id = $data['product_category_detail']->id ?? '';
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Category Detail</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Add/Edit Form</h3>
                        </div>
                    
                        <form role="form" id="product-category-add-edit" method="POST" action="{{ route('product.category.upsert') }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" class="form-control" id="product-category-id" name="product[id]" value="{{ $data['product_category_detail']->id ?? old('product.id') }}">

                            <div class="card-body">
                                @if ($errors->any())
                                    <div class='row'>
                                        <div class="col-md-6 offset-md-3 alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="productCategoryName">Category Name</label>
                                            <input type="text" class="form-control" id="productCategoryName" placeholder="Product Name" name="product[name]" value="{{ $data['product_category_detail']->name ?? old('product.name') }}" required>
                                        </div>
                                    </div>

                                </div>
                                    
                                <div class="row">
                                    <div class="col-md-6 offset-md-3 text-center">
                                        @if($id == '')
                                        <button type="submit" class="btn btn-warning btn-block">Save</button>
                                        @else
                                        <button type="submit" class="btn btn-warning btn-block">Update</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

    
@stop

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/css/admin_custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#product-description').summernote({
            height: 50,
            placeholder: 'Product Description',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        @php
        $description = $data['product_detail']->description ?? old('product.description');
        @endphp
        $('#product-description').summernote('code', '<?=$description?>');
        
        $(document).ready(function(){          
            $("#product-add-edit").validate({
                rules:{
                    "product[name]": {
                        required: true,
                    },
                    "product[available]":{
                        required:true
                    },
                    "product[featured]":{
                        required:true
                    },
                    "product[product_category_id]":{
                        required:true
                    },
                    "product[price]":{
                        required:true,
                        number:true,
                        min:1
                    },
                    "product[discount]":{
                        required:true,
                        number:true,
                        min:1
                    },
                    "product[description]":{
                        required:true
                    }
                }
            });
        });
    </script>
@stop