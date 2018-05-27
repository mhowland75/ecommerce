@extends('layouts.app')
@section('content')
<div id="page">
  <a href="/checkout/placeOrder">Bypass Payment</a>
  <div class="row">
    <div class="col-sm-4">
      <div class="panel panel-success">
      <div class="panel-heading">Address</div>
      <div class="panel-body">
        {{ $address[0]->firstline}}<br>
        {{ $address[0]->secondline}}<br>
        {{ $address[0]->city}}<br>
        {{ $address[0]->county}}<br>
        {{ $address[0]->postcode}}<br>
        {{ $address[0]->tel1}}<br>
        {{ $address[0]->tel2}}<br><br>
        <center><a href="/checkout/address"><button type="button" class="btn btn-primary btn-sm">Edit</button></a></center>
      </div>
      </div>
    </div>

    <div class="col-sm-4">
      <div class="panel panel-success">
      <div class="panel-heading">Delivery</div>
      <div class="panel-body">
      <h1> {{$delivery[0]->name}}</h1><br>
           {{$delivery[0]->eta}}<br>
           <?php if($delivery[0]->price == 0){echo'Free Shipping';}else{echo '£'. $delivery[0]->price;} ?><br>
           {{$delivery[0]->notes}}<br><br>
          <center> <a href="/checkout/delivery"><button type="button" class="btn btn-primary btn-sm">Edit</button></a></center>
      </div>
      </div>
    </div>

    <div class="col-sm-4">
      <div class="panel panel-success">
      <div class="panel-heading">Order Total</div>
      <div class="panel-body">
        <p>Basket Total: £{{$basketTotal}}</p><br>
        <?php if($delivery[0]->price == 0){echo'Delivery: Free';}else{echo'Delivery: £'.$delivery[0]->price;} ?><br>
          <?php if($discount > 0){echo'Discount: £'.$discount;} ?><br>
        <h2>Order Total: £{{$orderTotal}}</h2><br>
        <form class="form-horizontal" method="GET" action='/discounts/promoCodeValidation' >
            {{ csrf_field()}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <div class="form-group">
          <label for="usr">Promocode:</label>
          <input name="promoCode" type="text" class="form-control" id="usr">
            <center><button  type="submit" class="btn btn-success">Submit</button></center>
        </div>
      </form>
        <center><form action="https://www.paypal.com/cgi-bin/webscr" method="post">

          <!-- Identify your business so that you can collect the payments. -->
          <input type="hidden" name="business" value="Ecommerce">

          <!-- Specify a Buy Now button. -->
          <input type="hidden" name="cmd" value="_xclick">
          <input type="hidden" name="hosted_button_id" value="S3D35M7MFWCJ6">
          <!-- Specify details about the item that buyers will purchase. -->
          <input type="hidden" name="item_name" value="Basket Total">
          <input type="hidden" name="amount" value="0.01">
          <input type="hidden" name="currency_code" value="GBP">
          <input type="image" name="submit" border="0"
            src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png"
            alt="Buy Now">

          <img alt="" border="0" width="1" height="1"
          src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

        </form></center>
      </div>
      </div>
    </div>
</div>
      <div class="panel panel-info">
        <div class="panel-heading">Special Instructions</div>
        <div class="panel-body">
          <form action="/checkout/specialInstructions" method="post">
            {{ csrf_field()}}
              <div class="form-group">
                <textarea type="text" class="form-control" id="instructions" name="instructions" placeholder="{{$instructions}}"></textarea>
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
      </div>


</div>



</div>

@endsection
