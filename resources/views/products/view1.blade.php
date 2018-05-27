@extends('layouts.backend')
@section('content')
<div id="page">
  <div id="BEheader">
    <h1>Products</h1>
  </div>
  <div id="searchbar">
    <form class="form-horizontal" method="get" action='/products/backendProductSearch' >
      {{ csrf_field()}}
      <div class="form-group" >
      <label for="usr">Search by Products:</label>
      <select name="searchBy">
       <option value="name" <?php if($searchBy == 'name'){echo'selected';}?>>Name</option>
       <option value="id" <?php if($searchBy == 'id'){echo'selected';}?>>Id</option>
       <option value="primary_category" <?php if($searchBy == 'primary_category'){echo'selected';}?>>Primary Category</option>
       <option value="secondary_category" <?php if($searchBy == 'secondary_category'){echo'selected';}?>>Secondary Category</option>
       <option value="location" <?php if($searchBy == 'location'){echo'selected';}?>>Location</option>
      </select>
    </div>
    <div class="form-group">
        <label for="usr">Search:</label>
        <input name="search" type="text" class="form-control" id="usr" placeholder="{{$search}}">
    </div>
        <center><button  type="submit" class="btn btn-success">Search</button></center>
    </form>
</div>
  <table class="table">
      <thead>
        <tr>
          <th>Image</th>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Primary category</th>
          <th>Secondary category</th>
          <th>Stock</th>
          <th>Low stock level</th>
          <th>Update</th>
        </tr>
      </thead>
      <tbody>
  @forelse ($products as $product)
  <tr>
    <td><a href="/products/{{ $product->id}}">
      <img id="productSmallImage" src="{{$product->image}}" class="img-rounded"  >
    </a></td>
    <td>{{$product->id}}</td>
    <td>{{$product->name}}</td>
    <td>£{{$product->price}}</td>
    <td>{{$product->primary_category}}</td>
    <td>{{$product->secondary_category}}</td>
    <td>{{$product->stock}}</td>
    <td>{{$product->low_stock_level}}</td>
    <td><a href="/products/{{$product->id}}/edit">edit</a></td>
  </tr>

<br>
  @empty
  <h1>No Results</h1>
  @endforelse
</tbody>
</table>
{{ $products->appends(['searchBy' => $searchBy, 'search'=> $search])->links() }}
</div>
@endsection
