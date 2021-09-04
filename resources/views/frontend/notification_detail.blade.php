@extends('frontend.layouts.app')

@section('title')
    Notification Detail
@endsection

@section('content')

        <div class="notification-detail">

            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('frontend/img/Notifications_Monochromatic.png')}}" style="width: 220px" alt="">
                    </div>

                   <div class="text-center">
                        <h6 class="mb-1">{{$notification->data['title']}}</h6>
                        <p class="mb-1">{{$notification->data['message']}}</p>
                        <p class="mb-1">{{Carbon\Carbon::parse($notification->created_at)->format('Y-m-d h:i:s A')}}</p>
                        <a href="{{$notification->data['web_link']}}" class="btn btn-theme btn-sm mt-4">Continue</a>
                   </div>

                </div>
            </div>  

        </div>

@endsection

{{-- @section('js')
    
<script>

    $(document).ready(function(){

        $('.back-btn').on('click',function(){
            window.location.href('{{url("/")}}')
            return false;
        });

    });

@endsection --}}

