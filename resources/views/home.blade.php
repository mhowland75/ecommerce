@extends('layouts.app')
@section('content')
<div id="page">
  <div class="container">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="Banner/banner1.png" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="Banner/banner2.jpg" alt="Chicago" style="width:100%;">
      </div>

      <div class="item">
        <img src="Banner/banner3.jpg" alt="New york" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <div style="font-size:60px; postion:absolute; top:50%"><span><i style="font-size:60px;" class="ion-android-arrow-dropleft"></i></span></div>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span><i style="font-size:60px; padding-top:50%" class="ion-android-arrow-dropright"></i></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-4">
      <center>
        <i style="font-size:60px" class="ion-android-home"></i>
        <h3>Free Delivery</h3>
        <p>On orders over £50.</p>
      </center>
    </div>
    <div class="col-sm-4">
      <center>
        <i style="font-size:60px" class="ion-cash"></i>
        <h3>Money Back Guarantee</h3>
        <p>If you are unhappy with your product.</p>
        <p>you can return it free of charge.</p>
      </center>
    </div>
    <div class="col-sm-4">
      <center>
        <i style="font-size:60px" class="ion-android-happy"></i>
        <h3>Are values</h3>
        <p>To give the best.</p>
        <p>and nothing but the best.</p>
      </center>
    </div>
  </div>
</div>
<div class="page-header">
  <center>
  <h2>Latest Deals</h2>
</center>
</div>
<div class="container">
  <?php $x = 0; ?>
@forelse ($data as $product)
<?php
  if($product['product']->sale_percentage < 1 OR $x > 3){
    continue;
  }
  $x++
?>
<a href="/products/{{ $product['product']->id}}">
  <div class="col-xs-6 col-sm-4 col-lg-3">
    <div class="panel panel-default">
      <div style="height:355px" class="panel-body">
        <?php
        if(empty($product['image'][0]['image'])){
          $product['image'][0]['image'] = '/products/noimage.jpg';
        }
        ?>

          <?php if($product['product']->size_variation == 1 && $product['product']->sale_percentage > 0){
            echo '<div id="sale" height="10px" width="20px" style="background-color:red"><p>Save up to <br>'.$product['product']->sale_percentage .'%</p></div>';

          }
          elseif($product['product']->size_variation == 0 && $product['product']->sale_percentage > 0){
            echo '<div id="sale" height="10px" width="20px" style="background-color:red"><p>SAVE '.$product['product']->sale_percentage .'%</p></div>';
          }
          ?>

        <center><img id="productIndexImage" src="{{$product['image'][0]['image']}}" class="img-rounded" alt="no image"></center>
        <center><p id="productName">{{ $product['product']->name }}</p></center>
         @if(!$product['stars'] === 'No Reviews')
          <center>{!!$product['stars']!!}</center>
         @endif
         <center>{!!$product['stars']!!}</center>
        <center>
        <?php if($product['product']->size_variation == 1 && $product['product']->sale_percentage > 0){
          echo '<p id="priceText">From:</p> <p id="price">£'.number_format((float)$product['product']->price, 2, '.', '').'</p>';

        }
        elseif($product['product']->size_variation == 0 && $product['product']->sale_percentage > 0){
            echo '<p id="priceText">Price:<strike> £'.$product['product']->price.'</strike></p> <p id="price">£'. number_format((float)$product['product']->sale_price, 2, '.', '').'</p>';
        }
        else{
            echo '<p id="priceText">Price:</p> <p id="price">£'. number_format((float)$product['product']->price, 2, '.', '').'</p>';
        }
          ?>
        </center>
      </div>
    </div>
  </div>
    </a>
      @empty
          <p>No products</p>
      @endforelse
    </div>
</div>
@endsection
