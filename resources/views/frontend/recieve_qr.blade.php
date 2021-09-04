@extends('frontend.layouts.app')

@section('title')
    Recieve QR
@endsection

@section('content')

   <div class="recieve-qr">
    <div class="card">
        <div class="card-body">
            <p class="text-center mb-0">Scan QR to Pay!</p>
           <div class="text-center">
               <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->color(88, 66, 227)->size(240)->generate($authUser->phone)) !!} ">
           </div>
           <p class="text-center mb-1"><strong>{{$authUser->name}}</strong></p>
           <p class="text-center mb-1">{{$authUser->phone}}</p>
       </div>
    </div>
   </div>

@endsection
