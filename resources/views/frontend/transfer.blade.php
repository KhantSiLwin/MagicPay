@extends('frontend.layouts.app')

@section('title')
    Transfer
@endsection

@section('content')

        <div class="transfer">
                <div class="card">
                    <div class="card-body">
                        @include('frontend.layouts.flash')
                    <form action="{{url('transfer/confirm')}}" method="GET" id="transfer">
                        <input type="hidden" name="hash_value" class="hash_value" value="">
                       <div class="form-group">
                           <label for="" class="mb-1">From</label>
                           <p class="mb-1 text-muted">{{$user->name}}</p>
                           <p class="mb-1 text-muted">{{$user->phone}}</p>
                       </div>

                       <div class="form-group">
                            <label for="to_phone">To <span class="to_account_info"></span></label>
                            <div class="input-group">
                                <input type="number" value="{{old('to_phone')}}" class="form-control to_phone  @error('to_phone') is-invalid @enderror" name="to_phone">
                                <div class="input-group-append">
                                    <span class="input-group-text verify-btn btn" id="basic-addon2">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                </div>
                               </div>                         
                            @error('to_phone')
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                            @enderror
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

                $('.verify-btn').on('click',function(){
                    let phone = $('.to_phone').val();
                    $.ajax({
                        url : '@php
                                $url
                            @endphp./to-account-verify/?phone='+ phone,
                        type: 'GET',
                        success: function(res){
                            if(res.status == 'success'){
                                $('.to_account_info').html('<span class="text-success">('+res.data['name']+')</span>');
                            }
                            else{
                                $('.to_account_info').html('<span class="text-danger">(သေချာထည့်စမ်း)</span>');
                            }
                        }
                    })
                });

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
                                $('#transfer').submit();
                            }
                            else{

                            }
                        }
                    })

                }) ;

                });
        </script>

@endsection