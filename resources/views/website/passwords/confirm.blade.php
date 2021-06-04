@extends('layouts.website')

@section('body')
    <div class="page-heading page-heading-auth contact-heading header-text" style="background-image: url(public/assets/images/contact_banner.jpg);background-color: rgba(0, 0, 0, 0.7) !important;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h2>Confirm Password</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="auth-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-body">
                            <{{ __('Please confirm your password before continuing.') }}

                            <form method="POST" action="{{ route('customer_password.confirm') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Confirm Password') }}
                                        </button>

                                        @if (Route::has('customer_password.request'))
                                            <a class="btn btn-link" href="{{ route('customer_password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                    <</div>
                </div>
            </div>
        </div>
    </div>
@endsection
