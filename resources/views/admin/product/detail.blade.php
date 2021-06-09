@extends('layouts.admin')
@section('body')

@php
    $featureds = ['No','Yes'];
    $id = $data['product_detail']->id ?? '';
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Detail</h1>
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
                    
                        <form role="form" id="product-add-edit" method="POST" action="{{ route('product.upsert') }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" class="form-control" id="product-id" name="product[id]" value="{{ $data['product_detail']->id ?? old('product.id') }}">

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
                                

                                    @if(isset($id) && $id > 0 && ! $data['product_detail']->productImages->isEmpty())
                                    <div class="row">
                                        @foreach($data['product_detail']->productImages as $image)
                                        	@if($image->image_size == "thb")
                                                <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                                    <img id="image-{{ $image->product_id }}" src="{{ config('app.asset_url') }}/assets/images/products/{{ $image->product_id }}/{{ $image->image_path }}" width="100px">
                                                </div>
                                            @endif
                                        @endforeach
                                    	
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product-image">Upload Product Image</label>
                                                <input type="file" class="form-control" id="product-image" name="product[image]"  @php echo (isset($id) && $id > 0 && ! $data['product_detail']->productImages->isEmpty()) ? '' : 'required' @endphp>
                                            </div>
                                        </div>
                                        @if(isset($id) && $id > 0 && ! $data['product_detail']->productImages->isEmpty())
                                        	<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image-upload">--</label>
                                                        <button id="image-upload" type="submit" class="btn btn-warning btn-block" name="update_image" value="{{$id}}">Update Image</button>
                                                    </div>
                                    		</div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="productName">Product Name</label>
                                                <input type="text" class="form-control" id="productName" placeholder="Product Name" name="product[name]" value="{{ $data['product_detail']->name ?? old('product.name') }}" required>
                                            </div>
                                        </div>
                                        @if($id !== '')
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="productSlug">Product Slug</label>
                                                <input type="text" class="form-control" id="productSlug" placeholder="Product Slug" name="product[slug]" value="{{ $data['product_detail']->slug ?? old('product.name') }}" readonly>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="productCategories">Select Categories</label>
                                            <select class="form-control" id="productCategories" name="product[product_category_id]" required>
                                                <option value=''>Please select from list</option>
                                                @foreach($data['product_categories'] as $category)
                                                    <option value='{{ $category->id }}' {{ (isset($data['product_detail']->product_category_id) && ($data['product_detail']->product_category_id == $category->id)) ? 'selected' : old('product.product_category_id')}}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="productAvailability">Select How Many Product Available</label>
                                            <select class="form-control " id="productAvailability" name="product[available]" required>
                                                @foreach(range(0, 10) as $avail)
                                                    <option value='{{ $avail }}' {{ (isset($data['product_detail']->available) && ($data['product_detail']->available == $avail)) ? 'selected' : old('product.available') }}>{{ $avail }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="product-price">Product Price</label>
                                            <input type="text" inputmode="decimal" class="form-control" id="product-price" placeholder="Product Price" name="product[price]" value="{{ $data['product_detail']->price ?? old('product.price') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="product-discount">Product Discount</label>
                                            <input type="text" inputmode="decimal" class="form-control" id="product-discount" placeholder="Product discount" name="product[discount]" value="{{ $data['product_detail']->discount ?? old('product.discount') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="product-gst">GST Percentage</label>
                                            <input type="text" inputmode="decimal" class="form-control" id="product-gst" placeholder="GST Percentage" name="product[gst_percentage]" value="{{ $data['product_detail']->gst_percentage ?? old('product.gst_percentage') }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="productFeatured">Is it a featured Product?</label>
                                            <select class="form-control " id="productFeatured" name="product[featured]" required>
                                                <option value=''>Mark The Product</option>
                                                @foreach($featureds as $k => $v)
                                                    <option value='{{ $k }}' {{ (isset($data['product_detail']->featured) && ($data['product_detail']->featured == $k)) ? 'selected' : old('product.featured') }}>{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="product-description">Product Description</label>
                                            <textarea id="product-description" class="form-control" name="product[description]" required ></textarea>
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
                    
                    "product[gst_percentage]":{
                        required:true,
                        number: true,
                        max: 100
                    },
                    "product[description]":{
                        required:true
                    }
                }
            });
        });
    </script>
@stop