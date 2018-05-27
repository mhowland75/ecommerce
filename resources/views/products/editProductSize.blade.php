@extends('layouts.backend')
@section('content')
  <div id="page">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
              <div class="panel-heading"><center><h2>Edit {{$product[0]->name}} size {{$productSize[0]->size}}</h2></center></div>
                <div class="panel-body">
                  <form class="form-horizontal" method="POST" action='/products/size/update' >
                        {{ csrf_field()}}
                    <div class="col-md-10 col-md-offset-1">
                    <div class="form-group">
                      <input type="hidden" name="productSize_id" value="{{$productSize[0]->id}}">
                        <label for="usr">Size:</label>
                        <input name="size" type="text" class="form-control" id="usr"  value="{{ $productSize[0]->size}}">
                    </div>
                    <div class="form-group">
                        <label for="usr">price:</label>
                        <input name="price" type="text" class="form-control" id="usr" value="{{ $productSize[0]->price}}">
                    </div>
                    <div class="form-group">
                        <label for="usr">stock:</label>
                        <input name="stock" type="text" class="form-control" id="usr" value="{{ $productSize[0]->stock}}">
                    </div>
                    <div class="form-group">
                        <label for="usr">low stock level:</label>
                        <input name="low_stock_level" type="text" class="form-control" id="usr" value="{{ $productSize[0]->low_stock_level}}">
                    </div>
                    <div class="form-group">
                        <label for="usr">loaction:</label>
                        <input name="location" class="form-control" rows="5" id="comment" value="{{ $productSize[0]->location}}"></input>
                    </div>
                    <div class="form-group">
                        <label for="usr">sale percentage:</label>
                        <input name="sale_percentage" type="text" class="form-control" rows="5" id="comment"  value="{{ $productSize[0]->sale_percentage}}">
                    </div>

                      <center><button  type="submit" class="btn btn-success">Update</button></center>
                    </div>
                  </form>
                </div>
            </div>
        </div>
      </div>
    </div>
@endsection
