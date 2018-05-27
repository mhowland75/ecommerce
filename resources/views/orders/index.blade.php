@extends('layouts.backend')
@section('content')
<div id="page">
  <h1>Orders</h1>
  <table class="table">
      <thead>
        <tr>
          <th>Order Id</th>
          <th>Status</th>
          <th>Ordered at</th>
          <th>View</th>
        </tr>
      </thead>
      <tbody>
  @forelse ($orders as $order)
  <tr>
    <td>{{$order->id}}</td>
    <td>{{$order->order_status}}</td>
    <td>{{$order->created_at}}</td>
    <td><a href="/order/{{$order->id}}">View</a></td>
  </tr>
    @empty
        <p>There are no items in your basket.</p>
    </div>
    @endforelse
  </table>
</div>
@endsection
