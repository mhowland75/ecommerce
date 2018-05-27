@extends('layouts.app')
@section('content')
<div id="page">

  @if( Session::has( 'warning' ))
  <div class="alert alert-danger">
    <strong>{{ Session::get( 'warning' ) }}</strong>
  </div>
     @endif
     <div class="row">
         <div class="col-md-8 col-md-offset-2">
             <div class="panel panel-default">
               <div class="panel-heading"><center><h2>Review {{$product[0]->name}}</h2></center></div>
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
                  <form class="form-horizontal" method="POST" action='/reviews'>
                      {{ csrf_field()}}
                      <div class="col-md-8 col-md-offset-2">
                      <input type="hidden" name="product_id" value="{{$id}}">
                  <div class="form-group">
                      <label for="usr">Title:</label>
                      <input name="title" type="text" class="form-control" id="usr">
                  </div>
                  <div class="form-group">
                      <label for="usr">Rating:</label><br>
                      <input type="radio" name="rating" value="1"><img src="/stars_1.png"><br>
                      <input type="radio" name="rating" value="2"><img src="/stars_2.png"><br>
                      <input type="radio" name="rating" value="3"><img src="/stars_3.png"><br>
                      <input type="radio" name="rating" value="4"><img src="/stars_4.png"><br>
                      <input type="radio" name="rating" value="5" checked><img src="/stars_5.png"><br>
                  </div>
                  <div class="form-group">
                      <label for="usr">body:</label>
                      <textarea name="body" type="text" class="form-control" id="usr"></textarea>
                  </div>
                      <center><button  type="submit" class="btn btn-success">Send</button></center>
                    </div>
                  </form>
              </div>
            </div>
          </div>
        </div>
</div>
@endsection
