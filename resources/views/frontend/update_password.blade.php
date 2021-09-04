@extends('frontend.layouts.app')

@section('title')
Update Password
@endsection

@section('content')
  <div class="update-password">

    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-center">
                <img src="{{asset('frontend/img/security.png')}}" alt="">
            </div>

            <form action="{{route('update-password.store')}}" method="POST">
             @csrf

               
                <div class="form-group">
                    <label for="old_password">Old Password</label>
                    <input type="password" name="old_password" value="{{old('old_password')}}" class="form-control @error('old_password') is-invalid @enderror"">
                    @error('old_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
     
                <div class="form-group">
                 <label for="new_password">New Password</label>
                 <input type="password" name="new_password" value="{{old('new_password')}}" class="form-control @error('new_password') is-invalid @enderror"">
                 @error('new_password')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
             </div>
     
             <button type="submit" class="btn btn-theme btn-block mt-4">Update Password</button>
                
            </form>
        </div>
    </div>

  </div>
@endsection


@section('js')
    
  <script>
        $(document).ready(function(){
          
        })

  </script>

@endsection