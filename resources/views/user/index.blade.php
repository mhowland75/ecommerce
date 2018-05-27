@extends('layouts.backend')
@section('content')
<div id="page">
    <div class="row">
     <div class="col-sm-4">
       <ul class="list-group ">
         <li class="list-group-item">Total Users <span class="badge">{{$totalUsers}}</span></li>
         <li class="list-group-item">Online Users <span class="badge">{{$loggedinUsers}}</span></li>
         <li class="list-group-item">Registered users in last 7 days  <span class="badge">{{$registredUsers}}</span></li>
       </ul>
     </div>
     <div class="col-sm-4"><center><h1>Customers</h1></center></div>
     <div class="col-sm-4">
       <div class="panel panel-default">
         <div class="panel-heading">Users Search</div>
         <div class="panel-body">

           <form class="form-horizontal" method="get" action='/users' >
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
         <?php if($searchError == 1){echo'<div style="margin:5px" class="alert alert-info"><center>No Results Found</center></div>';}else{echo'';} ?>
       </div>
     </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-body">
        <table class="table table-striped">
            <thead>
              <tr>
                <th>User Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Last login</th>
                <th>Last logout</th>
                <th>Last activity</th>
                <th>Created at</th>
                <th>Details</th>
                <th>Activity</th>
              </tr>
            </thead>
            <tbody>
        @forelse ($users as $user)
        <tr>
          <td>{{$user->id}}</td>
          <td>{{$user->name}}</td>
          <td>{{$user->email}}</td>
          <td>{{$user->last_login}}</td>
          <td>{{$user->last_logout}}</td>
          <td>{{$user->last_activity}}</td>
          <td>{{$user->created_at}}</td>
          <td><a data-toggle="tooltip" title="View User Details" href="/users/{{$user->id}}"><i style="font-size:20px" class="ion-ios-glasses"></i></a></td>
          <td><a data-toggle="tooltip" title="View User Activity" href="/administrator/userActivity/{{$user->id}}"><i style="font-size:20px" class="ion-ios-navigate"></i></a></td>
      </tr>
        @empty

        @endforelse
      </table>
      </div>
    </div>


</div>
@endsection
