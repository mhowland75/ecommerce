@extends('layouts.backend')
@section('content')
<div id="page">
<h1>Order id: {{$order_id}}</h1>
<form action="/orders/picking/{{$order_id}}">
  <table class="table">
      <thead>
        <tr>
          <th>Picked</th>
          <th>Product</th>
          <th>Qty</th>
          <th>Location</th>
          <th>Price</th>

        </tr>
      </thead>
      <tbody>
@forelse ($orderProducts as $order)
@if ($order['product_size'] === array())
<tr>
  <td><input type="checkbox" class="cb-element" name="{{$order['orderedproduct']->id}}" value="1" <?php if($order['orderedproduct']->picked == 1){echo'checked';}?> ></td>
  <td>{{$order['productInfo'][0]->name}}</td>
  <td>{{$order['orderedproduct']->quantity}}</td>
  <td>{{$order['productInfo'][0]->location}}</td>
  <td>£{{$order['productInfo'][0]->price}}</td>
</tr>
@else
<tr>
  <td><input type="checkbox" class="cb-element" name="{{$order['orderedproduct']->id}}" value="1" <?php if($order['orderedproduct']->picked == 1){echo'checked';}?> ></td>
  <td>{{$order['productInfo'][0]->name}} {{$order['product_size'][0]->size}}</td>
  <td>{{$order['orderedproduct']->quantity}}</td>
  <td>{{$order['product_size'][0]->location}}</td>
  <td>£{{$order['product_size'][0]->price}}</td>
</tr>
@endif

  @empty
      <p>There are no items in your basket.</p>
  </div>

  @endforelse
</table>
  <input type="submit" value="Picked">
</form>
<a href="/orders/unpick/{{$order_id}}">Unpick order</a>
</div>
@endsection
