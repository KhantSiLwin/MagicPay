@extends('frontend.layouts.app')

@section('title')
    Magic Pay
@endsection

@section('content')

        <div class="home">
            <div class="row">
                <div class="col-12">
                    <div class="profile text-center mb-3">
                        <img src="https://ui-avatars.com/api/?background=5842E3&color=fff&name={{$user->name}}" alt="">
                        <h6 class="my-2">{{$user->name}}</h6>
                        <p class="text-muted">{{number_format($user->wallet ? $user->wallet->amount : 0)}} <span>MMK</span></p>
                    </div>
                </div>
       

        <div class="col-6">
           <a href="{{url('scan-and-pay')}}">
            <div class="card shortcut-box">
                <div class=" px-2 card-body">
                    <img src="{{asset('frontend/img/barcode-scanner.png')}}" class="mr-2" alt="">
                    <span>Scan & Pay</span>
                </div>
            </div>
           </a>
        </div>

        <div class="col-6">
           <a href="{{url('recieve-qr')}}">
            <div class="card shortcut-box">
                <div class=" px-2 card-body">
                    <img src="{{asset('frontend/img/qr-code.png')}}" class="mr-2" alt="">
                    <span>Recieve</span>
                </div>
            </div>
        </a>
        </div>


        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
        
                    <div class="cursor">
                      <a href="{{route('transfer')}}" class="d-flex justify-content-between">
                        <div class="shortcut-box">
                            <img src="{{asset('frontend/img/money-transfer.png')}}" class="mr-2" alt="">
                            <span>Transfer</span>
                        </div>
                        <span><i class="fas fa-angle-right"></i></span>
                      </a>
                    </div>
                    <hr>
        
                    <div class="cursor">
                        <a href="{{route('wallet')}}" class="d-flex justify-content-between">
                          <div class="shortcut-box">
                              <img src="{{asset('frontend/img/wallet.png')}}" class="mr-2" alt="">
                              <span>Wallet</span>
                          </div>
                          <span><i class="fas fa-angle-right"></i></span>
                        </a>
                      </div>
                      <hr>

                      <div class="cursor">
                        <a href="{{url('transaction')}}" class="d-flex justify-content-between">
                          <div class="shortcut-box">
                              <img src="{{asset('frontend/img/transaction.png')}}" class="mr-2" alt="">
                              <span>Transactions</span>
                          </div>
                          <span><i class="fas fa-angle-right"></i></span>
                        </a>
                      </div>

        
                </div>
            </div>
        </div>

    </div>

@endsection
