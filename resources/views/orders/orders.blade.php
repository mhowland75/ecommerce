@extends('layouts.backend')
@section('content')
<div id="page">
  <h1>{{$orderCount}} {{$orderStatus}} orders</h1>
  <form action="/orders/orders">
  <select name="sort">
  <option value="selected disabled hidden">Select a status</option>
  <option value="Payment Received">Payment Received</option>
  <option value="Picked">Picked</option>
  <option value="checked">Checked</option>
  <option value="dispached">Dispaced</option>
</select>

  <input type="submit" value="Find Orders">
</form>
<input type="checkbox" class="checkAll" onclick="$('input[type=checkbox][class=cb-element]').attr('checked',this.checked)"> Select all
  <form action="/orders/orders">
    <table class="table">
        <thead>
          <tr>
            <th>Select</th>
            <th>Order Id</th>
            <th>Staus</th>
            <th>Ordered At</th>
            <th>View</th>
            
          </tr>
        </thead>
        <tbody>
  @forelse ($orders as $order)
  <tr>
    <td><input type="checkbox" class="cb-element" name="orderId{{$order->id}}" value="{{$order->id}}" >
    <td>{{$order->id}}</td>
    <td>{{$order->order_status}}</td>
    <td>{{$order->created_at}}</td>
    <td><a href="/orders/picking/{{$order->id}}">view</a></td>
  </tr>
    @empty
        <p>There are no items in your basket.</p>
    </div>
    @endforelse
  </table>

    <select name="update_status">
      <option value="selected disabled hidden">Select to update</option>
      <option value="Payment Received">Payment Received</option>
      <option value="Picked">Picked</option>
      <option value="checked">Checked</option>
      <option value="dispached">Dispaced</option>
    </select>
    <input type="submit" value="Update">
</form>
</div>




@endsection
