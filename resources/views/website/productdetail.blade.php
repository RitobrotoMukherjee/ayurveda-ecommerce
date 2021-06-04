@extends('layouts.website')
@section('body')
     <!--Page Content--> 
    <div class="page-heading page-heading-auth contact-heading header-text" style="background-image: url(public/assets/images/contact_banner.jpg);background-color: rgba(0, 0, 0, 0.7) !important;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h2>{{ $data['product']->name }}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="products">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="text-center">
                        @if(isset($data['product']->productImages[1]))
                            <img src="{{ config('app.asset_url') }}/assets/images/products/{{ $data['product']->id }}/{{ $data['product']->productImages[1]->image_path }}" alt="" class="img-fluid wc-image">
                        @else
                            <img title="No Image Found" src="{{ config('app.asset_url') }}/assets/images/product-1-370x270.jpg " alt="no image" class="img-fluid wc-image"> 
                        @endif
                        @if($data['product']->available == 0)
                            <div class="sold-overlay">
                                <span class="sold-top-right sold red">Sold</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <h2>{{ $data['product']->name }}</h2>

                    <br>

                    <p class="lead">
                        @if($data['product']->discount > 0)
                            <small><del>&#8377;{{ $data['product']->price }} </del></small> &#8377;{{ $data['product']->price - $data['product']->discount }}
                        @else
                            &#8377;{{ $data['product']->price }}
                        @endif
                    </p>

                    <br>

                    <p class="lead">
                        {{ $data['product']->description }}
                    </p>

                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label">Quantity</label>
                            <div class="col-12">
                                {{ $data['product']->available }} - Available
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-12">
                                @if($data['product']->available != 0)
                                    @guest('customer')
                                        @if (Route::has('customer.login'))
                                            <a href="{{ route('customer.login') }}" class="filled-button">Add To Cart</a>
                                        @endif
                                    @else
                                        <a href="{{ route('cart.add', [$data['product']]) }}" class="filled-button">Add To Cart</a>
                                    @endguest
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
    <div class="latest-products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Similar Products</h2>
                        <a href="{{ route('products.list') }}">view more <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
                @if($data['similar_product']->isEmpty())
                    <div class="col-md-4 offset-md-4">
                        <h2>No Similar Products Found</h2>
                        <h4>Coming Soon.</h4>
                    </div>
                @endif
                @foreach ($data['similar_product'] as $product)
                    @if($product->id != $data['product']->id)
                   
                        <div class="col-md-3">
                            <div class="product-item">
                                <a href="{{ route('products.detail', [$product->slug]) }}">
                                    @if(isset($product->productImages[1]))
                                        <img src="{{ config('app.asset_url') }}/assets/images/products/{{ $product->id }}/{{ $product->productImages[1]->image_path }}"" alt="">
                                    @else
                                        <img title="No Image Found" src="{{ config('app.asset_url') }}/assets/images/product-1-370x270.jpg " alt="no image" > 
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
                                        <h6><small><del>&#8377;{{ $product->price }} </del></small>&#8377;{{ $product->price - $product->discount }}</h6>
                                    @else
                                        <h6>&#8377;{{ $product->price }}</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

@endsection