@extends('layouts.backend')
@section('content')
<div id="page">

  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading"><center><h2>Add New Product</h2></center></div>
              <div class="panel-body">
                <form class="form-horizontal" method="POST" action='/products/addproduct' >
                    {{ csrf_field()}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <div class="col-md-10 col-md-offset-1">
                <div class="form-group">
                    <label for="usr">Name:</label>
                    <input name="name" type="text" class="form-control" id="usr">
                </div>
                <div class="form-group">
                    <label for="usr">Primary Category:</label>
                    <input name="primary_category" type="text" class="form-control" id="usr">
                </div>
                <div class="form-group">
                    <label for="usr">Secondary Category:</label>
                    <input name="secondary_category" type="text" class="form-control" id="usr">
                </div>
                <div class="form-group">
                    <label for="usr">price:</label>
                    <input name="price" type="text" class="form-control" id="usr">
                </div>
                <div class="form-group">
                    <label for="usr">stock:</label>
                    <input name="stock" type="text" class="form-control" id="usr">
                </div>
                <div class="form-group">
                    <label for="usr">low stock level:</label>
                    <input name="low_stock_level" type="text" class="form-control" id="usr">
                </div>
                <div class="form-group">
                    <label for="usr">loaction:</label>
                    <input name="location" class="form-control" rows="5" id="comment"></input>
                </div>
                <div class="form-group">
                    <label for="usr">weight:</label>
                    <input name="weight" type="text" class="form-control" rows="5" id="comment"></input>
                </div>
                <div class="form-group">
                    <label for="usr">langth:</label>
                    <input name="langth" type="text" class="form-control" rows="5" id="comment"></input>
                </div>
                <div class="form-group">
                    <label for="usr">width:</label>
                    <input name="width" type="text" class="form-control" rows="5" id="comment"></input>
                </div>
                <div class="form-group">
                    <label for="usr">height:</label>
                    <input name="height" class="form-control" rows="5" id="comment"></input>
                </div>
                <div class="form-group">
                    <label for="usr">sale percentage:</label>
                    <input name="sale_percentage" type="text" class="form-control" rows="5" id="comment">
                </div>
                <div class="form-group">
                    <label for="usr">description:</label>
                    <textarea name="description" type="text" class="form-control" rows="5" id="comment"></textarea>
                </div>
                    <center><button  type="submit" class="btn btn-success">Add Product</button></center>
                </div>
                </form>
              </div>
          </div>
        </div>
      </div>
</div>
@endsection
