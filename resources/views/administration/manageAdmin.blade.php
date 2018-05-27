
@extends('layouts.backend')
@section('content')
<div id="page">
  <div class="row">
   <div class="col-sm-6">
     <div class="panel panel-default">
      <div class="panel-heading">Manage administrator privilages</div>
      <div class="panel-body">
      <div class="row">
        <div class="col-md-11 col-md-offset-1">
          <div class="row">
           <div class="col-sm-5">
            <b><p>Email</p></b>
           </div>
           <div class="col-sm-1">
            <b><p>Level</p></b>
           </div>
           <div class="col-sm-2">
           </div>
           <div class="col-sm-4">
              <b><p>Delete</p></b>
           </div>
          </div>
        <form class="form-horizontal" method="POST" action='/administrator/update'>
            {{ csrf_field()}}

        @forelse ($data as $admin)
        <div class="row">
         <div class="col-sm-5">
           {{$admin['userinfo'][0]->email}}
         </div>
         <div class="col-sm-1">
           {{$admin['admininfo']->access_level}}
         </div>
         <div class="col-sm-2">
           <div class="form-group">
               <select name="{{$admin['admininfo']->id}}" class="form-control">
                <option value="1" <?php if($admin['admininfo']->access_level == 1){echo'selected';}?>>1</option>
                <option value="2" <?php if($admin['admininfo']->access_level == 2){echo'selected';}?>>2</option>
                <option value="3" <?php if($admin['admininfo']->access_level == 3){echo'selected';}?>>3</option>
               </select>
           </div>
         </div>
         <div class="col-sm-4">
             <a href="/administrator/remove/{{$admin['admininfo']->id}}"><button type="button" class="btn btn-danger">Delete</button></a>
         </div>
        </div>
          @empty
              <p>No users</p>

          @endforelse
          <center><button  type="submit" class="btn btn-success">Update privileges</button></center>
      </form>
    </div>
  </div>
      </div>
    </div>
   </div>
   <div class="col-sm-6">
     <div class="panel panel-default">
      <div class="panel-heading">Create Administrator</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            @if($errors->any())
            <div class="alert alert-warning">
              <h4>{{$errors->first()}}</h4>
            </div>
           @endif
        <form class="form-horizontal" method="POST" action='/administrator/insert'>
            {{ csrf_field()}}
        <div class="form-group">
            <label for="usr">User Email:</label>
            <input name="email" type="text" class="form-control" id="usr">
        </div>
        <div class="form-group">
            <label for="usr">Access Level:</label>
            <select name="access_level" class="form-control">
             <option value="1">1</option>
             <option value="2">2</option>
             <option value="3">3</option>
            </select>
        </div>
            <center><button  type="submit" class="btn btn-success">Create Administrator</button></center>
        </form>
      </div>
    </div>
      </div>
    </div>
   </div>
  </div>
</div>
@endsection
