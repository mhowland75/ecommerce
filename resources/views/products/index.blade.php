@extends('layouts.app')
@section('content')
<div id="page">
  <div class="page-header">
    <div class="row">
     <div class="col-sm-8"><center><h2>{{$primary_category}} {{$secondary_category}}</h2></center></div>
     <div class="col-sm-4">
    <form action="/products/primary/{{$primary_category}}/secondary/{{$secondary_category}}">
      <div class="col-md-10 col-md-offset-1">
    <select class="form-control" name='sort' onchange='this.form.submit()'>
      <option<?php if($sort == 'Sort By:'){echo' selected';} ?>>Sort By:</option>
      <option<?php if($sort == 'Price: Low to High'){echo' selected';} ?>>Price: Low to High</option>
      <option<?php if($sort == 'Price: High to Low'){echo' selected';} ?>>Price: High to Low</option>
      <option<?php if($sort == 'Average Rating'){echo' selected';} ?>>Average Rating </option>
      <option<?php if($sort == 'Popularity'){echo' selected';} ?>>Popularity</option>
    </select>
    <noscript><input type="submit" value="Submit"></noscript>
  </div>
  </form>
   </div>
    </div>
  </div>
  <div class="row">
  <div id="productIndexContainer">
    @forelse ($data as $product)
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
</div>
@endsection
