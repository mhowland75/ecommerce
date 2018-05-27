@extends('layouts.app')
@section('content')
  <div id="page">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
              <div class="panel-heading">Edit Account Information</div>
                <div class="panel-body">
                <form class="form-horizontal" method="POST" action='/users/{{ $users->id }}'>
                    {{ method_field('PUT')}}
                    {{ csrf_field()}}
                      <div class="col-md-6 col-md-offset-3">
                        <div class="form-group">
                            <label for="usr">Name:</label>
                            <input name="name" type="text" class="form-control" id="usr" value="{{ $users->name}}"></input>
                        </div>
                        <div class="form-group">
                            <label for="usr">Email:</label>
                            <input name="email" type="text" class="form-control" id="usr" value="{{ $users->email}}"></input>
                      </div>
                    <center><button  type="submit" class="btn btn-success">Update</button></center>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    
@endsection
