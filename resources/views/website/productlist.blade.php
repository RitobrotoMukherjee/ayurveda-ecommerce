@extends('layouts.website')
@section('body')


     <!--Page Content--> 
    <div class="page-heading page-heading-auth contact-heading header-text" style="background-image: url(public/assets/images/contact_banner.jpg);background-color: rgba(0, 0, 0, 0.7) !important;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h2>Product List</h2>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="product-list">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 card-box">
                    <form id="search-form" method="GET" action="{{ route('products.list') }}">
                        <div class="input-group">
                            <input type="text" id="product-search" name="search" class="form-control" placeholder="search products by name" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn waves-effect waves-light btn-danger"><i class="fa fa-search mr-1"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @if($data['products']->isEmpty())
                    <div class="col-md-4 offset-md-4">
                        <h2>No Products Found</h2>
                        <h4>Search something else.</h4>
                    </div>
                @endif
                @foreach ($data['products'] as $product)
                    <div class="col-md-4">
                        <div class="product-item">
                          <a href="{{ route('products.detail', [$product->slug]) }}">
                                @if(isset($product->productImages[1]))
                                    <img src="{{ config('app.asset_url') }}/assets/images/products/{{ $product->id }}/{{ $product->productImages[1]->image_path }}" alt="" class="img-thumbnail img-list-view">
                                @else
                                    <img title="No Image Found" src="{{ config('app.asset_url') }}/assets/images/product-1-370x270.jpg " alt="no image" class="img-fluid wc-image"> 
                                    
                                @endif
                              @if($product->available == 0)
                                <div class="sold-overlay">
                                    <span class="sold-top-right sold red">Sold</span>
                                </div>
                              @endif
                          </a>
                          <div class="down-content">
                            <a href="{{ route('products.detail', [$product->slug]) }}"><h4>{{ $product->name }}</h4></a>
                            @if($product->discount > 0)
                                <h6><small><del>&#8377;{{ $product->price }} </del></small> &#8377;{{ $product->price - $product->discount }}</h6>
                            @else
                                <h6>&#8377;{{ $product->price }}</h6>
                            @endif
                            <p class="product-list-description">{{ $product->description }}</p>
                            <div class="row">
                                @if($product->available != 0)
                                    <div class="col-md-6">
                                        @guest('customer')
                                            @if (Route::has('customer.login'))
                                                <a href="{{ route('customer.login') }}" class="filled-button">Add To Cart</a>
                                            @endif
                                        @else
                                            <a href="{{ route('cart.add', [$product]) }}" class="filled-button">Add To Cart</a>
                                        @endguest

                                    </div>
                                @endif
                                <div class="col-md-6">
                                      <a href="{{ route('products.detail', [$product->slug]) }}" class="filled-button">View Details</a>
                                </div>
                            </div>

                          </div>

                        </div>

                    </div>
                
                @endforeach
                

            </div>
        </div>
    </div>

@endsection