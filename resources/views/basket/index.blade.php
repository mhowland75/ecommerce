
@extends('layouts.app')
@section('content')

<div id="page">
  @if( !empty($products[0][0]->id))
  <div class="page-header">
    <h1>Basket</h1>
  </div>
  <form method="POST" action="/basket/basketUpdate">
    {{ csrf_field()}}
    <div class="row">
     <div class=" col-xs-3 col-sm-3 col-lg-2">
       Product Name
     </div>
     <div class="col-xs-2 col-sm-2 col-lg-2">
       Qty.
     </div>
     <div class="col-xs-2 col-sm-2 col-lg-2">
       Discount
     </div>
     <div class="col-xs-2 col-sm-2 col-lg-2">
       Unit Price
     </div>
     <div class="col-xs-2 col-sm-2 col-lg-2">
      Product total
     </div>
     <div class="col-xs-1 col-sm-1 col-lg-2">
     </div>
    </div>
    <br>
  @endif
    @forelse ($products as $product=>$x)
        @if(!empty($x['size'][0]->size))
          <div class="row">
           <div class="col-xs-3 col-sm-3 col-lg-2">
             {{$x[0]->name}}  {{$x['size'][0]->size}}
           </div>
           <div class="col-xs-2 col-sm-2 col-lg-2">
             <input class="form-control" type="text" name="{{$x[1]->id}}" value="{{$x[1]->quantity}}">
           </div>
           <div class="col-xs-2 col-sm-2 col-lg-2">
             <?php if($x['size'][0]->sale_percentage >0){echo $x['size'][0]->sale_percentage.'%';} ?>
           </div>
           <div class="col-xs-2 col-sm-2 col-lg-2">
            £{{number_format($x['size'][0]->price,2)}}
           </div>
           <div class="col-xs-2 col-sm-2 col-lg-2">
             £{{number_format($x['size'][0]->price * $x[1]->quantity,2)}}
           </div>
           <div class="col-xs-1 col-sm-1 col-lg-2">
            <a href="/basket/remove/{{$x[1]->id}}"><i style="font-size:20px" class="ion-close-round"></i></a>
           </div>
          </div>
        @else
        <div class="row">
         <div class="col-xs-3 col-sm-3 col-lg-2">
           {{$x[0]->name}}
         </div>
         <div class="col-xs-2 col-sm-2 col-lg-2">
           <input  class="form-control" type="text" name="{{$x[1]->id}}" value="{{$x[1]->quantity}}">
         </div>
         <div class="col-xs-2 col-sm-2 col-lg-2">
           <?php if($x[0]->sale_percentage >0){echo '%'.$x[0]->sale_percentage.'%';} ?>
         </div>
         <div class="col-xs-2 col-sm-2 col-lg-2">
           £{{number_format($x[0]->price,2)}}
         </div>
         <div class="col-xs-2 col-sm-2 col-lg-2">
           £{{number_format($x[0]->price * $x[1]->quantity,2)}}
         </div>
         <div class="col-xs-1 col-sm-1 col-lg-">
          <a href="/basket/remove/{{$x[1]->id}}"><i style="font-size:20px" class="ion-close-round"></i></a>
         </div>
        </div>
        @endif
        <br>
      @empty
          <p>There are no items in your basket.</p>
      @endforelse
      @if( !empty($products[0][0]->id))
      <div class="row">
       <div class="col-sm-4"><a href="/checkout/address"><button type="button" class="btn btn-primary">Checkout</button></a></div>
       <div class="col-sm-4"><button type="submit" class="btn btn-primary">Update Basket</button></div>
       <div class="col-sm-4"><h4>Order Total: £{{$basketTotal}}</h4></div>

      </div>
      @endif
</form>
</div>
@endsection
