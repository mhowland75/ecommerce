
@extends('layouts.app')
@section('content')
<script>
function showStock(str) {

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              //console.log(this.responseText);
                document.getElementById("stockLevel").innerHTML = this.responseText;

            }
        };
        xmlhttp.open("GET","/products/ajaxSize/"+str,true);
        xmlhttp.send();

}
</script>

<div id="page">

  <div class="row">
   <div class="col-sm-12 col-md-6">
     <div class="panel panel-default">
        <div class="panel-body">
        <div id="productImage">
          <img style="display: block; margin: auto;" id="mainImg" src="{{$productImages[0]->image}}" class="img-thumbnail" alt="{{ $product->name }}">
        </div></div>
        <div style="overflow: hidden" class="panel-footer">
                 @forelse ($productImages as $image)
                 <div id="moreImages" onclick='document.getElementById("mainImg").src="{{$image->image}}"'>
                   <img src="{{$image->image}}" class="img-rounded">
                 </div>
                   @empty
                   @endforelse
        </div>
      </div>

   </div>

   <div class="col-sm-12  col-md-6">
     <div class="panel panel-default">
      <div style="padding:5%" class="panel-body">
       <form class="form-horizontal" method="POST" action='/basket'>
           {{ csrf_field()}}
         <h2>{{ $product->name }}</h2><br>
         <?php $x = 1 ?>
       @forelse ($productSizes as $size)
           <input  onchange="showStock(this.value)" <?php if($x == 1){echo'checked="checked"';}?> type="radio" name="size" value="{{$size->id}}"> {{$size->size}} <?php if(!$size->sale_price == 0){echo '<strike>£ '.$size->price.'</strike> <b>£'. $size->sale_price.'</b> '.$size->sale_percentage.'% off';}else{echo '<b>£'.$size->price.'</b>';}?><br>
           <?php $x++?>
         @empty
         <h2><?php if($product->sale_percentage > 0){echo $product->sale_percentage.'% OFF <br> </h2><p>Was:<strike>£'. number_format((float)$product->price, 2, '.', '').'</strike></p><h2><b> £'.number_format((float)$product->sale_price, 2, '.', '').'</b>';}else{echo '<b>£'. $product->price.'</b>';} ?></h2><br>
         <h4>Stock: {{$product->stock}}</h4>
         @endforelse
         <div id="stockLevel"><?php if(!empty($productSizes[0]->id)){echo 'Stock: '.$productSizes[0]->stock;} ?></div>
         <br>
       <div>{!!$stars!!} <?php if($reviewCount == 0){echo'<a href="/reviews/create/'.$product->id.'">Be the first to review this item</a>';}else{echo $reviewCount.' Reviews';}?> </div>
       <div id="addToCartForm">
         <input name="product_id" type="hidden" value="{{ $product->id}}">
         <div class="form-group">
             <label for="usr">Qty:</label>
             <select name="quantity">
               <option value="1">1</option>
               <option value="2">2</option>
               <option value="3">3</option>
               <option value="4">4</option>
               <option value="5">5</option>
               <option value="6">6</option>
               <option value="7">7</option>
               <option value="8">8</option>
               <option value="9">9</option>
               <option value="10">10</option>
             </select>
             <button type="submit" class="btn btn-primary">Add to cart</button>
         </form>
     </div>
    </div>

      </div>
    </div>

</div>
</div>

    <div id="moreProductInfo" class="container">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Description</a></li>
        <li><a data-toggle="tab" href="#menu1">Reviews</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <h3>Description</h3>
          <p>{{ $product->description}}</p>
        </div>
        <div id="menu1" class="tab-pane fade">
          <h3>Reviews</h3>
          <?php if($reviewCount == 0){echo'<a href="/reviews/create/'.$product->id.'">Be the first to review this item</a>';}else{echo $reviewCount.' Reviews <br> <a href="/reviews/create/'.$product->id.'"><button type="button" class="btn">Review Product</button></a><br>';}?><br>
          @forelse ($data as $review)
          <div class="panel panel-default">
            <div class="panel-heading"><h4>{{ $review['review']->title }}</h4> <b>{{ $review['user'][0]->name }}</b>  {{$review['review']->created_at }}</div>
            <div class="panel-body">{!!$review['review']->rating!!}<br><br>{{ $review['review']->body }}</div>
          </div>
            @empty
                <p>No reviews</p>
            @endforelse
        </div>
      </div>
    </div>
</div>
@endsection
