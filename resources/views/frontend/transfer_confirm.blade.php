@extends('frontend.layouts.app')

@section('title')
    Transfer
@endsection

@section('content')

        <div class="transfer">
                <div class="card">
                    <div class="card-body">
                        @include('frontend.layouts.flash')
                    <form action="{{url('transfer/complete')}}" method="POST" id="form">
                  @csrf
                        <input type="hidden" name="hash_value" value="{{$hash_value}}">
                        <input type="hidden" name="to_phone" value="{{$to_account->phone}}">
                        <input type="hidden" name="amount" value="{{$amount}}">
                        <input type="hidden" name="description" value="{{$description}}">
                       <div class="form-group">
                           <label for="" class="mb-0"><strong>From</strong></label>
                           <p class="mb-1 text-muted">{{$from_account->name}}</p>
                           <p class="mb-1 text-muted">{{$from_account->phone}}</p>
                       </div>

                       <div class="form-group">
                            <label for="to_phone" class="mb-0"><strong>To</strong></label>
                            <p class="mb-1 text-muted">{{$to_account->name}}</p>
                             <p class="mb-1 text-muted">{{$to_account->phone}}</p>
                       </div>

                        <div class="form-group">
                            <label for="amount" class="mb-0"><strong>Amount</strong></label>
                            <p class="mb-1 text-muted">{{$amount}}</p>
                        </div>

                        <div class="form-group">
                            <label for="description" class="mb-0"><strong>Description</strong></label>
                            <p class="mb-1 text-muted">{{$description}}</p>
                        </div>

                        <button type="submit" class="btn btn-theme btn-block confirm-btn mt-5">Continue</button>
                    </form>
                    </div>
                </div>
        </div>

@endsection


@section('js')
    
  <script>
        $(document).ready(function(){
            $('.confirm-btn').on('click',function(e){

            e.preventDefault();
            $('.password').focus();

            Swal.fire({
            title: 'Please fill your password!',
            icon:'info',
            html:'<input type="password" class="form-control text-center password" autofocus/>',
            showCancelButton: true,
            confirmButtonText: `Confirm`,
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            }).then((result) => {

            if (result.isConfirmed) {

                let password = $('.password').val();

                $.ajax({
                    
                    url : '@php
                                $url
                         @endphp./password-check?password='+password,
                    type: 'POST',
                    success: function(res){
                       if(res.status == 'success'){
                           $('#form').submit();
                       }
                       else{
                        Swal.fire({
                            title: 'Oops...',
                            icon:'error',
                            text:res.message,
                            })
                       }
                    }
                })
            }

            })
            })
        })

  </script>

@endsection