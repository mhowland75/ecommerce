@extends('layouts.backend')
@section('content')
  <div id="page">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
              <div class="panel-heading"><center><h2>Edit Product {{ $product->name}}</h2></center></div>
                <div class="panel-body">
                <form class="form-horizontal" method="POST" action='/products/{{ $product->id }}'>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-10 col-md-offset-1">
                <div class="form-group">
                    <label for="usr">Name:</label>
                    <input name="name" type="text" class="form-control" id="usr" value="{{ $product->name}}"></input>
                </div>
                <div class="form-group">
                    <label for="usr">Primary Category:</label>
                    <input name="primary_category" type="text" class="form-control" id="usr" value="{{ $product->primary_category}}">
                </div>
                <div class="form-group">
                    <label for="usr">Secondary Category:</label>
                    <input name="secondary_category" type="text" class="form-control" id="usr"value="{{ $product->secondary_category}}">
                </div>
                <div class="form-group">
                    <label for="usr">price:</label>
                    <input name="price" type="text" class="form-control" id="usr" value="{{ $product->price}}"></input>
                </div>
                <div class="form-group">
                    <label for="usr">stock:</label>
                    <input name="stock" type="text" class="form-control" id="usr" value="{{ $product->stock}}"></input>
                </div>
                <div class="form-group">
                    <label for="usr">low stock level:</label>
                    <input name="low_stock_level" type="text" class="form-control" id="usr" value="{{ $product->low_stock_level}}">
                </div>
                <div class="form-group">
                    <label for="usr">loaction:</label>
                    <input name="location" class="form-control" rows="5" id="comment" value="{{ $product->location}}"></input>
                </div>
                <div class="form-group">
                    <label for="usr">sale percentage:</label>
                    <input name="sale_percentage" type="text" class="form-control" rows="5" id="comment"  value="{{ $product->sale_percentage}}">
                </div>
                <div class="form-group">
                    <label for="usr">description:</label>
                    <input name="description" class="form-control" rows="5" id="comment" value="{{ $product->description}}"></input>
                </div>
                <div class="form-group">
                    <label for="usr">weight:</label>
                    <input name="weight" class="form-control" rows="5" id="comment" value="{{ $product->weight}}"></input>
                </div>
                <div class="form-group">
                    <label for="usr">langth:</label>
                    <input name="langth" class="form-control" rows="5" id="comment" value="{{ $product->langth}}"></input>
                </div>
                <div class="form-group">
                    <label for="usr">width:</label>
                    <input name="width" class="form-control" rows="5" id="comment" value="{{ $product->width}}"></input>
                </div>
                <div class="form-group">
                    <label for="usr">height:</label>
                    <input name="height" class="form-control" rows="5" id="comment" value="{{ $product->height}}"></input>
                </div>
                    <center><button  type="submit" class="btn btn-success">Send</button></center>
                </div>
                </form>
                <form action="/products/{{ $product->id}}" method="post" >
                  {{ csrf_field()}}
                  {{method_field('DELETE')}}
                  <button>Delete</button>
                </form>
              </div>
          </div>
        </div>
      </div>
    </div>
@endsection
