@extends('frontend.layouts.app')

@section('title')
    Scan and Pay Form
@endsection

@section('content')

        <div class="scan-and-pay">
                <div class="card">
                    <div class="card-body">
                    <form action="{{url('scan-and-pay/confirm')}}" method="GET" id="scanandpay">
                        <input type="hidden" name="hash_value" class="hash_value" value="">
                        <input type="hidden" value="{{$to_account->phone}}" class="form-control to_phone" name="to_phone">
                       <div class="form-group">
                           <label for="" class="mb-1">From</label>
                           <p class="mb-1 text-muted">{{$from_account->name}}</p>
                           <p class="mb-1 text-muted">{{$from_account->phone}}</p>
                       </div>

                       <div class="form-group">

                            <label for="to_phone">To <span class="to_account_info"></span></label>
                            <p class="mb-1 text-muted">{{$to_account->name}}</p>
                            <p class="mb-1 text-muted">{{$to_account->phone}}</p>
                       </div>

                      

                        <div class="form-group">
                            <label for="amount">Amount</label>
                           <input type="number" value="{{old('amount')}}" class="form-control amount  @error('amount') is-invalid @enderror" name="amount">
                           @error('amount')
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                           <input type="text" value="{{old('description')}}" class="form-control description" name="description">
                        </div>

                        <button type="submit" class="btn btn-theme btn-block mt-5 submit-btn">Continue</button>
                    </form>
                    </div>
                </div>
        </div>

@endsection


@section('js')
    
        <script>
            $(document).ready(function(){


                $('.submit-btn').on('click',function(e){

                    e.preventDefault();
                    let to_phone = $('.to_phone').val();
                    let amount = $('.amount').val();
                    let description = $('.description').val();
                    $.ajax({
                        url : `@php
                                $url
                            @endphp./transfer-hash?to_phone=${to_phone}&amount=${amount}&description=${description}`,
                        type: 'GET',
                        success: function(res){
                            if(res.status == 'success'){
                                $('.hash_value').val(res.data);
                                $('#scanandpay').submit();
                            }
                            else{

                            }
                        }
                    })

                }) ;

                });
        </script>

@endsection