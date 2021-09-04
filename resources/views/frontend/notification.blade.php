@extends('frontend.layouts.app')

@section('title')
    Notification
@endsection

@section('content')

        <div class="notification">

               <div class="infinite-scroll">
                @foreach ($notifications as $notification)
                <a href="{{url('notification/'.$notification->id)}}">

                <div class="card mb-2">
                    <div class="card-body p-2">

                        <div class="d-flex justify-items-around">
                            <i class="fas fa-bell pl-2 pr-3 @if (is_null($notification->read_at))text-danger @endif"></i>
                            <div class="">
                                <h6 class="mb-1">{{Illuminate\Support\Str::limit($notification->data['title'],40)}}</h6>
                                <p class="mb-0">{{Illuminate\Support\Str::limit($notification->data['message'],40)}}</p>
                                <p class="mb-0">{{Carbon\Carbon::parse($notification->created_at)->format('Y-m-d h:i:s A')}}</p>
    
                            </div>
                        </div>

                     
                      
                    </div>
                </div>
            </a>
                @endforeach
                {{ $notifications->links() }}   
            </div>
        </div>

@endsection

@section('js')

<script>
    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<div class="text-center"><img class="center-block" src="{{asset('frontend/img/Spinner-5.gif')}}" alt="Loading..." /></div>',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });

       
    });
</script>
@endsection