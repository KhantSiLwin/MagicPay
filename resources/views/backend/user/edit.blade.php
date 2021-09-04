@extends('backend.layouts.app')

@section('title')
    Edit Users
@endsection

@section('user')
    mm-active
@endsection

@section('icon')
users
@endsection

@section('content')

      <div class="pt-3">
        <div class="card">
            <div class="card-body">

                @include('backend.layouts.flash')

                <form action="{{route('admin.user.update',$user->id)}}" method="post" id="update">
                   
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{$user->name,old('name')}}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{$user->email,old('email')}}">
                    </div>

                    <div class="form-group">
                        <label for="phone">phone</label>
                        <input type="text" name="phone" class="form-control" value="{{$user->phone,old('phone')}}">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="d-flex justify-content-center">
                        <button class="btn btn-secondary back-btn">Cancle</button>
                        <button class="btn btn-primary ml-2">Confirm</button>
                    </div>

                </form>
            </div>
        </div>
      </div>
@endsection

@section('js')
    
{!! JsValidator::formRequest('App\Http\Requests\UpdateAdminUser','#update') !!}

      <script>

        //   {!! JsValidator}

      </script>

@endsection