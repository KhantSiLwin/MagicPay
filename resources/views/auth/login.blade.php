@extends('frontend.layouts.app_plain')

@section('title')
   Login 
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-11 col-md-8 col-lg-6">
            <div class="card auth-form">
               
               <div class="text-center mt-4">
                <h2>Login</h2>
                <p class="text-muted">Fill the form to login</p>
               </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="phone" class="text-md-right">Phone</label>

                            <div class="">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="text-md-right">Password</label>

                            <div class="">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-theme btn-block my-4 py-2">
                            Login            
                         </button>

                        <div class="d-flex justify-content-between">
                           
                                <a href="{{route('register')}}"  class="btn btn-link">Don't have an account?</a>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
