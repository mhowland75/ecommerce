@extends('layouts.app')
@section('content')
<div id="page">
  <div class="row">
  @forelse ($deliveryMethods as $delivery)
    @if ($delivery->active == 1)
    <a href="/checkout/delivery/{{$delivery->id}}">
       <div class="col-sm-4">
         <div class="panel panel-default">
          <div class="panel-heading"><h3>{{$delivery->name}}</h3><br></div>
          <div class="panel-body">
                {{$delivery->eta}}<br>
                <?php if($delivery->price == 0){echo'Free';}else{echo'£'.$delivery->price;} ?><br>
                {{$delivery->notes}}<br>
            </div>
        </div>
       </div>
     </a>
    @endif

     @empty

    @endforelse
  </div>

</div>

@endsection
