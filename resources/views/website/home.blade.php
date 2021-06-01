@extends('layouts.website')
@section('body')
<style>
    .page-heading:before{background-color: transparent !important;}
</style>

    <!-- Page Content -->
    <!-- Banner Starts Here, it's carousal -->
<!--    <div class="banner header-text">
      <div class="owl-banner owl-carousel">
        <div class="banner-item-01">
          <div class="text-content">
            <h4>Find your ayurvedic medicine!</h4>
          </div>
        </div>
        <div class="banner-item-02">
          <div class="text-content">
            <h4>Natural Honey</h4>
          </div>
        </div>
      </div>
    </div>-->
    <!-- Banner Ends Here -->
    
    <!-- for just image view -->
    <!--<div class="banner header-text" style='padding-top: 80px;'>-->
        <!--<div class="page-heading about-heading header-text" style="padding: 350px 0px 130px 0px !important;background-image: url(public/assets/images/Home_Page_Banner.jpg);">-->
        <div class="page-heading about-heading header-text" style="background-image: url(public/assets/images/Home_Page_Banner.jpg);">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="text-content">
                    <!--<h2>about us</h2>-->
                  </div>
                </div>
              </div>
            </div>
        </div>
    <!--</div>-->
    
    <!-- static image banner ends -->
    <div class="best-features">
      <div class="container">
        <div class="row">
            {{-- Success Alert --}}
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('status')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
          <div class="col-md-12">
            <div class="section-heading">
              <h2>We Are Sree Krishna Ayurveda</h2>
            </div>
          </div>
          <div class="col-md-12">
            <div class="left-content">
                <p><em>Sree Krishna Ayurvedic Pharmacy</em> Established in 1918 by Dr. Sri Peddinti Rangacharyulu (Great Grandfather of the present Proprietor Sri Peddinti Venugopal) Carried out Manufacturing of Ayurvedic Medicines useful for the Mankind.  Some of the Patented Medicines also spreaded all over the World.</p>
                <p>Presently Dealing in Import and Export of Ayurvedic medecines <a href="{{ route('about-us') }}" class="filled-button">Read More</a></p>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="best-features">
        <div class="container">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="section-heading">
                      <h2>Featured Products</h2>
                      <a href="{{ route('products.list') }}">view more <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="left-content">
                        <ul class="featured-list">
                            @foreach($data['product_categories'] as $v)
                                <li><a target="_blank" href="{{ route('products.list', ['product_category_id' => $v->id]) }}">{{$v->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                    @foreach ($data['products'] as $product)
                        <div class="col-md-6 col-sm-6">
                            <div class="product-item">
                              <a href="{{ route('products.detail', [$product->slug]) }}">
                                    @if(isset($product->productImages[1]))
                                        <img src="{{ config('app.asset_url') }}/assets/images/products/{{ $product->id }}/{{ $product->productImages[1]->image_path }}" alt="" class="img-thumbnail img-list-view">
                                    @else
                                        <img title="No Image Found" src="{{ config('app.asset_url') }}/assets/images/product-1-370x270.jpg " alt="no image" class="img-fluid wc-image"> 
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
                                    <div class="col-md-6">
                                        @guest('customer')
                                            @if (Route::has('customer.login'))
                                                <a href="{{ route('customer.login') }}" class="filled-button">Add To Cart</a>
                                            @endif
                                        @else
                                            <a href="{{ route('cart.add', [$product]) }}" class="filled-button">Add To Cart</a>
                                        @endguest

                                    </div>
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
        </div>
    </div>
@endsection