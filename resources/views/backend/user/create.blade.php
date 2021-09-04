@extends('backend.layouts.app')

@section('title')
    Create Users
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

                <form action="{{route('admin.user.store')}}" method="post" id="create">
                   
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{old('email')}}">
                    </div>

                    <div class="form-group">
                        <label for="phone">phone</label>
                        <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
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

{!! JsValidator::formRequest('App\Http\Requests\StoreAdminUser','#create') !!}
    
      <script>

          

      </script>

@endsection