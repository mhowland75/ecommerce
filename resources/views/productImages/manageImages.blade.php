@extends('layouts.backend')
@section('content')
<div id="page">
  <div class="panel panel-default">
    <div class="panel-heading"> <center><h4>Images for {{$products[0]->name}}</h4></center></div>
  <div class="panel-body">
    <div class="container-fluid">
   <div class="row">
     @forelse ($images as $image)
     <div class="col-sm-3" >
       <div class="panel panel-default">
        <div class="panel-body"> <img src="{{$image->image}}" class="img-thumbnail"></div>
        <div class="panel-footer"><center><a href="/products/images/manage/remove/{{$image->id}}"><button type="button" class="btn btn-danger">Remove</button></a></center></div>
      </div>
     </div>
     @empty
     <h1>No Results</h1>
     @endforelse
  </div>
</div>

 </div>
</div><br>
<div class="container">
 <div class="row">
   <div class="col-sm-6 col-md-offset-3" >
     <div class="panel panel-default">
     <div class="panel-heading"> <center><h4>Add new images for {{$products[0]->name}}</h4></center></div>
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
       <form class="form-horizontal" method="POST" action='/products/images/manage/add'enctype="multipart/form-data" >
           {{ csrf_field()}}
           <input type="hidden" name="product_id" value="{{$id}}">
       <center><div class="form-group">
           <label for="usr">image:</label>
           <input type="file" name="image"  multiple></input>
       </div></center>
           <center><button  type="submit" class="btn btn-success">Add Image</button></center>
       </form>

     </div>
   </div>
   </div>
 </div>
</div>


@endsection
