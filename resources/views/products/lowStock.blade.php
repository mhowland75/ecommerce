@extends('layouts.backend')
@section('content')
<div id="page">
  <div class="row">
   <div class="col-sm-4">
     <ul class="list-group">
       <li class="list-group-item">Total low stock<span class="badge">{{$lowStockProductsCount}}</span></li>
       <li class="list-group-item">Out of stock <span class="badge">{{$outOfStockProductsCount}}</span></li>

      </ul>
   </div>
   <div class="col-sm-4">
     <form action="/products/lowstock">
      <div class="form-group">
      <label>Product location code:</label>
      <input type="text" class="form-control" name="productlocation">
     </div>
     <div class="form-group">
      <label>Add to quantity:</label>
      <input type="text" class="form-control" name="qty">
     </div>
      <input type="submit" value="Submit">
    </form>
   </div>
   <div class="col-sm-4">
     @if($errors->any())
        <h4>{{$errors->first()}}</h4>
      @endif
      <div class="panel panel-default">
        <div class="panel-heading">Product Search</div>
        <div class="panel-body">
          <form class="form-horizontal" method="get" action='/products/lowstock' >
            {{ csrf_field()}}
            <div class="col-md-10 col-md-offset-1">
              <div class="input-group">
               <input name="search" type="text" class="form-control" id="usr" placeholder="{{$search}}">
                <div class="input-group-btn">
                  <button class="btn btn-default" type="submit">
                    <i class="ion-ios-search-strong"></i>
                  </button>
                </div>
              </div>
              <br>
              <a href="/products/lowstock"><button type="button" class="btn btn-info">Clear Search</button></a>
            </div>
          </form>

        </div>
        <?php if($searchError == 1){echo'<div style="margin:5px" class="alert alert-info"><center>No Results Found</center></div>';}else{echo'';} ?>
      </div>
   </div>
  </div>
  <div class="panel panel-default">
  <div class="panel-heading"><h2>Low Stock Products</h2></div>
  <div class="panel-body">
    <table class="table table-striped">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Size</th>
            <th>Primary Catigory</th>
            <th>Secondary Catigory</th>
            <th>Stock Level</th>
            <th>Low stock level</th>
            <th>Location</th>
            <th>Update</th>
          </tr>
        </thead>
        <tbody>
      @forelse ($lowStockProducts as $product)
      <tr>
        <td>{{ $product->name }}</td>
        <td><?php if(!empty($product->size)){echo $product->size;}?></td>
        <td>{{ $product->primary_category }}</td>
        <td>{{ $product->secondary_category }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->low_stock_level }}</td>
        <td>{{ $product->location }}</td>
        <td><a href="/products/{{ $product->id }}/edit"><i style="font-size:20px" class="ion-edit"></i></a></td>
        @empty
          <p>No low stock products</p>
        @endforelse
  </div>
</div>
</div>

@endsection
