@extends('layouts.website')
@section('body')


    <!-- Page Content -->
    <div class="page-heading contact-heading header-text" style="background-image: url(public/assets/images/contact_banner.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h2>Contact Us</h2>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="find-us">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Our Location on Maps</h2>
            </div>
          </div>
          <div class="col-md-8">
<!-- How to change your own map point
	1. Go to Google Maps
	2. Click on your location point
	3. Click "Share" and choose "Embed map" tab
	4. Copy only URL and paste it within the src="" field below
-->
            <div id="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15285.470962169014!2d81.110158!3d16.7084933!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb1f53e4ded2f04e9!2sSree%20Krishna%20Ayurvedic%20Pharmacy!5e0!3m2!1sen!2sin!4v1620288228864!5m2!1sen!2sin" width="100%" height="330px" frameborder="0" style="border:0" allowfullscreen loading="lazy"></iframe>
            </div>
          </div>
          <div class="col-md-4">
            <div class="left-content">
              <h4>About our office</h4>
              <h5>ADDRESS</h5>
              <p>Sree Krishna Ayurvedic Pharmacy<br/>ELURU, W.G.Dt., A.P</p>
              <br>
              <h5>Mail ID</h5>
              <p><a href="mailto: sreekrishnaayurvedicpharmacy@gmail.com" target="_top">sreekrishnaayurvedicpharmacy@gmail.com</a></p>
              <br>
              <h5>Customer Care</h5>
              <p><a href="tel: +919989512445" target="_top">+91 9989 512 445</a></p>
              <ul class="social-icons">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="#"><i class="fa fa-behance"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection