  @extends('layouts.backend')
  @section('content')
  <div id="page">
    <div class="row">
     <div class="col-sm-6">
       <div class="panel panel-default">
        <div class="panel-heading"><center><h2>{{$product[0]->name}} Sizes</h2><center></div>
        <div class="panel-body">
          <table class="table">
          <thead>
            <tr>
              <th>Sizes</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Location</th>
              <th>Sale percentage</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($productSizes as $sizes)
            <tr>
              <td>{{$sizes->size}}</td>
              <td>{{$sizes->price}}</td>
              <td>{{$sizes->stock}}</td>
              <td>{{$sizes->location}}</td>
              <td>{{$sizes->sale_percentage}}%</td>
              <td><a data-toggle="tooltip" title="Product visablity" href="/products/activateProduct/size/{{$sizes->id}}"><?php if($sizes->active == 1){echo'<i style="font-size:20px" class="ion-eye"></i>';}else{echo'<i style="font-size:20px" class="ion-eye-disabled"></i>';} ?> </a></td>
              <td><a data-toggle="tooltip" title="Edit Product size" href="/products/size/edit/{{$sizes->id}}"><i style="font-size:20px" class="ion-edit"></i></a></td>
            </tr>
              @empty
              @endforelse
          </tbody>
        </table>
        </div>
      </div>
     </div>
     <div class="col-sm-6">
       <div class="panel panel-default">
        <div class="panel-heading"><center><h2>Add New Size Variation</h2></center></div>
        <div class="panel-body">
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          <div class="row">
              <div class="col-md-8 col-md-offset-2">
                        <form class="form-horizontal" method="POST" action='/products/size/add' >
                            {{ csrf_field()}}
                            <input type="hidden" name="product_id" value="{{$product_id}}">
                        <div class="form-group">
                            <label for="usr">Size:</label>
                            <input name="size" type="text" class="form-control" id="usr">
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
                            <label for="usr">sale percentage:</label>
                            <input name="sale_percentage" type="text" class="form-control" rows="5" id="comment"  >
                        </div>

                            <center><button  type="submit" class="btn btn-success">Send</button></center>
                        </form>
                      </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  @endsection
