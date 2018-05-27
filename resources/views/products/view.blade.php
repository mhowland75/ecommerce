@extends('layouts.backend')
@section('content')
<div id="page">
        <ul class="list-group col-sm-4">
          <li class="list-group-item">Total Products <span class="badge">{{$totalProducts}}</span></li>
          <li class="list-group-item">Low Stock <span class="badge">{{$lowStockProducts}}</span></li>
          <li class="list-group-item">Out of Stock <span class="badge">{{$outOfStockProducts}}</span></li>
          <li class="list-group-item">Active  <span class="badge">{{$activeProducts}}</span></li>
          <li class="list-group-item">Inactive <span class="badge">{{$inactiveProducts}}</span></li>
        </ul>
        <ul class="list-group col-sm-4">
          <li class="list-group-item">Products with size variations<span class="badge">{{$sizeVariation}}</span></li>
          <li class="list-group-item">Total size variations <span class="badge">{{$totalSizeVariations}}</span></li>
          <li class="list-group-item">Sale Items <span class="badge">{{$saleItems}}</span></li>
          <li class="list-group-item">Size variation on sale<span class="badge">{{$saleSizeProducts}}</span></li>
          <li class="list-group-item">Total product views<span class="badge">{{$totalProductViews}}</span></li>
        </ul>

<div class="row">
   <div class="col-sm-4 pull-right">
     <div class="panel panel-default">
       <div class="panel-heading">Product Search</div>
       <div class="panel-body">

         <form class="form-horizontal" method="get" action='/products/view' >
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
           </div>
         </form>

       </div>
       <?php if($searchError == 1){echo'<div style="margin:5px" class="alert alert-info"><center>No Results Found</center></div>';}else{echo'';} ?>
     </div>
   </div>
  </div>
    <div class="panel panel-default">
      <div class="panel-body">
        <table class="table table-striped">
            <thead>
              <tr>
                <th>Image</th>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Primary category</th>
                <th>Secondary category</th>
                <th>Location</th>
                <th>Stock</th>
                <th>Low stock level</th>
                <th>Times viewed</th>
              </tr>
            </thead>
            <tbody>

        @forelse ($data as $product)
        <?php
        if(empty($product['image'][0]['image'])){
          $product['image'][0]['image'] = '/products/noimage.jpg';
        }
        ?>
        <tr>
          <td><a href="/products/{{ $product['product']->id}}">
            <img id="productSmallImage" src="{{$product['image'][0]['image']}}" class="img-rounded"  >
          </a></td>
          <td>{{$product['product']->id}}</td>
          <td>{{$product['product']->name}}</td>
          <td>£{{$product['product']->price}}</td>
          <td>{{$product['product']->primary_category}}</td>
          <td>{{$product['product']->secondary_category}}</td>
          <td>{{$product['product']->location}}</td>
          <td>{{$product['product']->stock}}</td>
          <td>{{$product['product']->low_stock_level}}</td>
          <td>{{$product['product']->times_viewed}}</td>

          <td><a data-toggle="tooltip" title="View Product" href="/products/{{ $product['product']->id}}"><i style="font-size:20px" class="ion-easel"></i></a></td>
          <td><a data-toggle="tooltip" title="Edit Product" href="/products/{{$product['product']->id}}/edit"><i style="font-size:20px" class="ion-edit"></i></a></td>
          <td><a data-toggle="tooltip" title="Products Visablity" href="/products/activateProduct/{{$product['product']->id}}"><?php if($product['product']->active == 1){echo'<i style="font-size:20px" class="ion-eye"></i>';}else{echo'<i style="font-size:20px" class="ion-eye-disabled"></i>';} ?></a></td>
          <td><a data-toggle="tooltip" title="Manage Product Images" href="/products/images/manage/{{$product['product']->id}}"><i style="font-size:20px" class="ion-images"></i></a></td>
          <td><a data-toggle="tooltip" title="Manage Product Sizes" href="/products/size/{{$product['product']->id}}"><i style="font-size:20px" class="ion-arrow-resize"></i></a></td>
        </tr>
        @empty
        <h1>No Results</h1>
        @endforelse
      </tbody>
      </table>
      </div>
    </div>
</div>
@endsection
