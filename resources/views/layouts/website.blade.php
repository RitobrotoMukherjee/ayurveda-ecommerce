<!DOCTYPE html>
<html lang="en">
    <?php //$data['cart_count'] = session()->get('cart');print_r(($data));die;?>
    @php
        if(session()->get('cart') !== null){
            $data['cart_count'] = count(session()->get('cart'));
        }
    @endphp

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta name="description" content="Indian Ayurvedic Pharmacy">
    <meta name="author" content="Ritobroto Mukherjee">
    <meta property="article:publisher" content="https://ritobroto-mukherjee.blogspot.com">
    <link rel="icon" href="{{ config('app.asset_url') }}/assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Sree Krishna Ayurvedic</title>

    <link href="{{ config('app.asset_url') }}/css/app.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ config('app.asset_url') }}/assets/css/fontawesome.css">
    <link rel="stylesheet" href="{{ config('app.asset_url') }}/assets/css/style.v1.css">
    <link rel="stylesheet" href="{{ config('app.asset_url') }}/assets/css/owl.css">
    
    

  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="" id="myHeader" >
      <nav class="navbar navbar-expand-lg">
        <div class="container">
            <div class="navbar-header navbar-left">
                @if(!isset($data['page'])) 
                    @guest('customer')
                        <a class="navbar-brand" href="{{ route('home') }}"><h2>Sree Krishna <em>Ayurvedic Pharmacy</em></h2></a>
                    @else
                        <a class="navbar-brand" href="{{ route('customer.dashboard') }}"><h2>Sree Krishna <em> Pharmacy</em></h2></a>
                    @endguest
                @endif
            </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="nav navbar-nav ml-auto">
				<li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about-us') }}">About Us</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ route('products.list') }}" role="button" aria-haspopup="true" aria-expanded="false" >Products</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($data['product_categories'] as $v)
                            <a class="dropdown-item" href="{{ route('products.list', ['product_category_id' => $v->id]) }}">{{$v->name}}</a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact-us') }}">Contact Us</a></li>
                
                @guest('customer')
                    @if (Route::has('customer.login'))
                        <li class="nav-item"><a href="{{ route('customer.login') }}" class="nav-link">Login/Sign Up</a></li>
                    @endif
                @else
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::guard('customer')->user()->name }}</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('customer.logout') }}" 
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            
                            <a class="dropdown-item" href="{{ route('customer.orders') }}">My Orders</a>
                            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('addtocart') }}" id="cart">
                            <i class="fa fa-shopping-cart"></i> Cart <span id="cart-items" data-count="{{ $data['cart_count'] }}" class="cart-count" ></span>
                        </a>
                    </li>
                
                @endguest
                
                
            </ul>
          </div>
        </div>
      </nav>
    </header>

    @yield('body')


    <div class="call-to-action">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <div class="row">
                <div class="col-md-8">
                  <h4>Contact Us</h4>
                  <p>For any query or details feel free to contact us.</p>
                </div>
                <div class="col-lg-4 col-md-6 text-right">
                  <a href="{{ route('contact-us') }}" class="filled-button">Contact Us</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a href="https://api.whatsapp.com/send?phone=919966660399&text=Hello." class="wa-button" target="_blank">
        <i class="fa fa-whatsapp my-wa-button"></i>
    </a>
    
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <p>Copyright © {{ date('Y') }} Sree Krishna Ayurvedic Pharmacy - Developed by: <a href="http://sunglobal.online/" target='_blank'>SUN GLOBAL</a></p>
            </div>
          </div>
        </div>
      </div>
    </footer>


    <!-- Bootstrap core JavaScript -->
    <script src="{{ config('app.asset_url') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ config('app.asset_url') }}/js/app.js" defer></script>
    <!--<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>-->


    <!-- Additional Scripts -->
    <script src="{{ config('app.asset_url') }}/assets/js/custom.js"></script>
    <script src="{{ config('app.asset_url') }}/assets/js/owl.js"></script>
    
    

  </body>
</html>