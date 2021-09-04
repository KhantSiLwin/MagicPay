<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#5842e3">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
     <div class="spinner-box" id="load">
        <div class="pulse-container">  
          <div class="pulse-bubble pulse-bubble-1"></div>
          <div class="pulse-bubble pulse-bubble-2"></div>
          <div class="pulse-bubble pulse-bubble-3"></div>
        </div>
      </div>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('backend/css/main.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    <style>

            @keyframes pulse {
            from {
                opacity: 1;
                transform: scale(1);
            }
            to {
                opacity: .25;
                transform: scale(.75);
            }
            }

        .spinner-box {
            height: 100%;
            width: 100%;
            position: fixed;
            z-index: 150;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color:rgba(248, 248, 248, 0.699) ;
            top:-0px; 
            }
        /* PULSE BUBBLES */

            .pulse-container {
            width: 120px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            }

            .pulse-bubble {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #5843e2;
            }

            .pulse-bubble-1 {
                animation: pulse .4s ease 0s infinite alternate;
            }
            .pulse-bubble-2 {
                animation: pulse .4s ease .2s infinite alternate;
            }
            .pulse-bubble-3 {
                animation: pulse .4s ease .4s infinite alternate;
            }
            
    </style>
    @yield('css')
</head>
<body onload="document.getElementById('load').style.display='none';"> 
    <div id="app">

        <div class="header-menu">
            <div class="d-flex justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="row text-center py-2">
                        <div class="col-2">
                            @if (!request()->is('/'))

                            @if (session('transfer_success'))
                            <a href="{{route('home')}}">
                                <i class="fas fa-chevron-left mt-2"></i>
                            </a>
                          
                            @else
                            <a href="#" class="back-btn">
                                <i class="fas fa-chevron-left mt-2"></i>
                            </a>
                            @endif
                           @endif
                        </div>
                        <div class="col-8">
                            <h4 class="mb-0">@yield('title')</h4>
                        </div>
                        <div class="col-2">
                            <a href="{{url('notification')}}">
                               <div class="position-relative">
                                <i class="fas fa-bell mt-2"></i>
                                @if ($unread_noti_count>0)
                                <span class="badge badge-danger noti-badge">{{$unread_noti_count}}</span>

                                @endif
                               </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    @yield('content')
                </div>
            </div>
        </div>

        <div class="bottom-menu">
            <a href="{{url('scan-and-pay')}}" class="scan-tab d-flex justify-content-center align-items-center">
                <div class="inside d-flex justify-content-center align-items-center">
                    <i class="fas fa-qrcode mt-0"></i>
                </div>
            </a>
            <div class="d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="row text-center">
                        <div class="col-3 p-0">
                            <a href="{{route('home')}}">
                                <i class="fas fa-home"></i>
                                <p class="mb-0">Home</p>
                            </a>
                        </div>
                        <div class="col-3 p-0">
                            <a href="{{route('wallet')}}">
                                <i class="fas fa-wallet"></i>
                                 <p class="mb-0">Wallet</p>
                            </a>
                        </div>
                        <div class="col-3 p-0">
                            <a href="{{url('transaction')}}">
                                <i class="fas fa-exchange-alt"></i>
                                 <p class="mb-0">Transaction</p>
                            </a>
                        </div>
                        <div class="col-3 p-0">
                            <a href="{{route('profile')}}">
                                <i class="fas fa-user"></i>
                                <p class="mb-0">Profile</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

      <!-- Scripts -->
      <script src="{{asset('backend/js/jquery-3.5.1.js')}}"></script>
      <script src="{{asset('js/bootstrap4.min.js')}}"></script>
      {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
      <script src="{{asset('backend/js/sweetalert2.js')}}"></script>
      <script src="{{asset('js/jscroll.js')}}"></script>

        <script>

            $(document).ready(function(){
                let token = document.head.querySelector('meta[name="csrf-token"]');
                    if(token){
                        $.ajaxSetup({
                            headers : {
                                'X-CSRF-TOKEN' :token.content,
                                'Content-Type' :'application/json',
                                'Accept' :'application/json',
                            }
                        });
                    }

                    $('.back-btn').on('click',function(){
                        window.history.go(-1);
                        return false;
                    });

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                        })

                        @if (session('update'))
                            Toast.fire({
                                icon: 'success',
                                title:"{{session('update')}}"
                            }) 
                        @endif

                       
    })
        </script>

      @yield('js')
</body>
</html>
