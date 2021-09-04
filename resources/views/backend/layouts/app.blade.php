<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{csrf_token()}}">
 
    <title>@yield('title')</title>


    <link rel="stylesheet" href="{{asset('backend/css/main.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('backend/css/bootstrap.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('backend/css/datatables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/style.css')}}">

    @yield('css')

</head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            @include('backend.layouts.header')
            @include('backend.layouts.uitheme')
         <div class="app-main">
              @include('backend.layouts.sidebar')
                 <div class="app-main__outer">
                    <div class="app-main__inner">
 
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-@yield('icon') icon-gradient bg-mean-fruit">
                                        </i>
                                    </div>
                                    <div>
                                       @yield('title')
                                    </div>
                                </div>
                            </div>
                        </div>   

                        @yield('content')
                   


                    </div>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    <span>Copyright {{date('Y')}} All right reserved by Magic Pay.</span>
                                </div>
                                <div class="app-footer-right">
                                    <span>Developed By Noel.</span>
                                </div>
                            </div>
                        </div>
                    </div>  
              </div>  
        </div>
    </div>
<script type="text/javascript" src="{{asset('backend/js/main.js')}}"></script>
<script src="{{asset('backend/js/jquery-3.5.1.js')}}"></script>
<script src="{{asset('backend/js/jquery.datatables.min.js')}}"></script>
<script src="{{asset('backend/js/datatables.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{asset('backend/js/sweetalert2.js')}}"></script>

<script>
    $(document).ready(function(){

        let token = document.head.querySelector('meta[name="csrf-token"]');
        if(token){
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' :token.content
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

        @if (session('create'))
            Toast.fire({
                icon: 'success',
                title: "{{session('create')}}"
            }) 
        @endif

        @if (session('update'))
            Toast.fire({
                icon: 'success',
                title:"{{session('update')}}"
            }) 
        @endif

    });
</script>

@yield('js')

</body>
</html>
