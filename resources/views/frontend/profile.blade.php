@extends('frontend.layouts.app')

@section('title')
Profile
@endsection

@section('content')
  <div class="account">


    <div class="profile text-center mb-3">
        <img src="https://ui-avatars.com/api/?background=5842E3&color=fff&name={{$user->name}}" alt="">
    </div>


    <div class="card mb-3">
        <div class="card-body">

            <div class="d-flex justify-content-between">
                <span>Name</span>
                <span>{{$user->name}}</span>
            </div>
            <hr>

            <div class="d-flex justify-content-between">
                <span>Phone</span>
                <span>{{$user->phone}}</span>
            </div>
            <hr>

            <div class="d-flex justify-content-between">
                <span>Email</span>
                <span>{{$user->email}}</span>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="cursor">
              <a href="{{route('update-password')}}" class="d-flex justify-content-between">
                <span>Upadate Password</span>
                <span><i class="fas fa-angle-right"></i></span>
              </a>
            </div>
            <hr>

            <div class="d-flex justify-content-between cursor logout">
                <span>Logout</span>
                <span><i class="fas fa-angle-right"></i></span>
            </div>

        </div>
    </div>

  </div>
@endsection


@section('js')
    
  <script>
        $(document).ready(function(){
            $(document).on('click','.logout',function(e){

            e.preventDefault();
          

            Swal.fire({
            title: 'Are you sure?',
            showCancelButton: true,
            confirmButtonText: `Confirm`,
            reverseButtons: true,
            }).then((result) => {

            if (result.isConfirmed) {
                $.ajax({
                    
                    url : "{{route('logout')}}",
                    type: 'POST',
                    success: function(){
                        window.location.replace('{{route('profile')}}');
                    }
                })
            }

            })
            })
        })

  </script>

@endsection