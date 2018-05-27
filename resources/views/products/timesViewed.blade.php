@extends('layouts.backend')
@section('content')
<div id="page">
  <div class="row">
   <div class="col-sm-6">
     <div class="panel panel-default">
      <div class="panel-heading">Most Viewed Products</div>
      <div class="panel-body">
        <table class="table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Added On</th>
                <th>Times Viewed</th>
              </tr>
            </thead>
            <tbody>
        @forelse ($productViews as $product)
        <tr>
          <td>{{$product->name}}</td>
          <td>{{$product->created_at}}</td>
          <td>{{$product->times_viewed}}</td>
        </tr>
        @empty

        @endforelse
      </table>
      </div>
    </div>
   </div>
   <div class="col-sm-6">
     <div class="panel panel-default">
      <div class="panel-heading">Most Ordered Products</div>
      <div class="panel-body">
        <table class="table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Added On</th>
                <th>Times Viewed</th>
              </tr>
            </thead>
            <tbody>
        @forelse ($productOrdereds as $productOrdered)
        <tr>
          <td>{{$productOrdered->name}}</td>
          <td>{{$productOrdered->created_at}}</td>
          <td>{{$productOrdered->times_ordered}}</td>
        </tr>
        @empty

        @endforelse
      </table>
      </div>
    </div>
   </div>

</div>
@endsection
