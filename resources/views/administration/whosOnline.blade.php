@extends('layouts.backend')
@section('content')
<div id="page">
  <div class="row">
   <div class="col-sm-4">
     <ul class="list-group">
       <li class="list-group-item">Online Users <span class="badge">{{$onlineUsers}}</span></li>
       <li class="list-group-item">Inactive Users <span class="badge">{{$inactiveUsers}}</span></li>
       <li class="list-group-item">Offline Users <span class="badge">{{$offlineUsers}}</span></li>
      </ul>
   </div>
   <div class="col-sm-8"></div>
  </div>
  <div class="panel panel-default">
  <div class="panel-heading"><center><h2>Customers Online</h2></center></div>
  <div class="panel-body">
    <table class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Last activity</th>
            <th>Last login</th>
            <th>Last logout</th>
          </tr>
        </thead>
        <tbody>
    @forelse ($users as $user)
    <tr>
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td><?php if($user->online == 1){echo'Online';}elseif($user->online == 2){echo'Inactive';}?></td>
      <td>{{$user->last_activity}}</td>
      <td>{{$user->last_login}}</td>
      <td>{{$user->last_logout}}</td>
      <td><a data-toggle="tooltip" title="Edit User" href="/users/{{$user->id}}/edit"><i style="font-size:20px" class="ion-edit"></i></a></td>
      <td><a data-toggle="tooltip" title="View User Activity" href="/administrator/userActivity/{{$user->id}}"><i style="font-size:20px" class="ion-load-d"></a></td>
    </tr>
    <br>
    @empty
    <h1>No Users Online</h1>
    @endforelse
  </table>
  </div>
</div>


</div>
@endsection
