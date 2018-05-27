
@extends('layouts.backend')
@section('content')

<div id="page">

  <div class="row">
   <div class="col-sm-4"></div>
   <div class="col-sm-4"></div>
   <div class="col-sm-4">
     <div class="panel panel-default">
      <div class="panel-heading">Search</div>
      <div class="panel-body">
      <div class="col-md-10 col-md-offset-1">
        <form class="form-horizontal" method="get" action='/reviews' >
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
      </div>
    </div>
   </div>
 </div>
<br>
    <div class="panel panel-default">

      <div class="panel-body">
        <table class="table">
            <thead>
              <tr>
                <th>Customer</th>
                <th>Product</th>
                <th>title</th>
                <th>Star Rating</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
          @forelse ($data as $review)
          <tr>
            <?php $id = $review['review'][0]->id; ?>
            <td>{{$review['user'][0]->name}}</td>
            <td>{{$review['product'][0]->name}}</td>
            <td>{{$review['review'][0]->title}}</td>
            <td>{!!$review['review'][0]->rating!!}</td>
            <td>{{$review['review'][0]->body}}</td>
            <td><?php if($review['review'][0]->active == 1){echo '<a href="review/visability/'.$id.'"><i style="font-size:20px" class="ion-eye"></i></a>';}else{echo '<a href="review/visability/'.$id.'"><i style="font-size:20px" class="ion-eye-disabled"></i></a>';}; ?></td>
          </tr>
            @empty
                <p>No Reviews</p>
            @endforelse
          </table>
      </div>
    </div>
</div>

@endsection
