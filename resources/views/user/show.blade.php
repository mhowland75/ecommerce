@extends('layouts.backend')
@section('content')
<div id="page">
  <div class="page-header">
  <h1>{{$users[0]->name}}</h1>
</div>

<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Personal Information</a></li>
    <li><a data-toggle="tab" href="#menu1">Address</a></li>
    <li><a data-toggle="tab" href="#menu2">Orders</a></li>
    <li><a data-toggle="tab" href="#menu3">Product Revews</a></li>
  </ul>
<br>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <div class="row">
       <div class="col-sm-6">
         <div class="panel panel-default">
          <div class="panel-heading">User Details</div>
          <div class="panel-body">
    <table class="table table-bordered">
    <tbody>
      <tr>
        <td>Name:</td>
        <td>{{$users[0]->name}}</td>
      </tr>
      <tr>
        <td>Email:</td>
        <td>{{$users[0]->email}}</td>
      </tr>
      <tr>
        <td>Registered:</td>
        <td>{{$users[0]->created_at}}</td>
      </tr>
      <tr>
        <td>Online:</td>
        <td><?php if($users[0]->online == 0){echo'Offline';}elseif($users[0]->online == 1){echo'Online';}elseif($users[0]->online == 2){echo'Inactive';} ?></td>
      </tr>
      <tr>
        <td>Last Loggedin:</td>
        <td>{{$users[0]->last_login}}</td>
      </tr>
      <tr>
        <td>Last Activity:</td>
        <td>{{$users[0]->last_activity}}</td>
      </tr>
      <tr>
        <td></td>
        <td><a href="/users/{{$users[0]->id}}/edit">Edit</a></td>
      </tr>
    </tbody>
  </table>

          </div>
        </div>
       </div>
       </div>
    </div>
    <div id="menu1" class="tab-pane fade">
      <div class="row">
         <div class="col-sm-6">
           <div class="panel panel-default">
            <div class="panel-heading">Address</div>
            <div class="panel-body">
              @forelse ($addresss as $address)
              {{ $address->firstline}}<br>
              {{ $address->secondline}}<br>
              {{ $address->city}}<br>
              {{ $address->county}}<br>
              {{ $address->postcode}}<br>
              {{ $address->tel1}}<br>
              {{ $address->tel2}}<br><br>
              @empty

              @endforelse
            </div>
          </div>
         </div>
       </div>
    </div>
    <div id="menu2" class="tab-pane fade">
      <div class="row">
       <div class="col-sm-12">
         <div class="panel panel-default">
          <div class="panel-heading">Orders</div>
          <div class="panel-body">
            <table class="table table-striped">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Status</th>
            <th>Payment type</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($orders as $order)
          <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->order_status}}</td>
            <td>{{$order->payment_type}}</td>
          </tr>
          @empty
          @endforelse
        </tbody>
      </table>

       </div>
       </div>
       </div>
     </div>
    </div>
    <div id="menu3" class="tab-pane fade">
      <div class="row">
       <div class="col-sm-12">
         <div class="panel panel-default">
          <div class="panel-heading">Reviews</div>
          <div class="panel-body">
         <table class="table table-striped">
            <thead>
              <tr>
                <th>Title</th>
                <th>Rating</th>
                <th>Body</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($reviews as $review)
                <tr>
                  <td>{{$review->title}}</td>
                  <td> {!!$review->rating!!}</td>
                  <td>{{$review->body}}</td>
                  <td>{{$review->created_at}}</td>
                </tr>
              @empty

              @endforelse

            </tbody>
          </table>
        </div>
        </div>
        </div>
        </div>
    </div>
  </div>
</div>
@endsection
