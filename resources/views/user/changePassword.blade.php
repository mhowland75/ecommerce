@extends('layouts.app')
@section('content')
  <div id="page">
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
              <div class="panel panel-default">
                  <div class="panel-heading">Edit Password</div>
                  <div class="panel-body">
                    <form class="form-horizontal" method="POST" action='/users/password/update'>
                        {{ csrf_field()}}
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group">
                            <label for="usr">New Password:</label>
                            <input name="newpassword" type="text" class="form-control" id="usr" >
                        </div>
                        <div class="form-group">
                            <label for="usr">Repeate new password:</label>
                            <input name="repeatpassword" type="text" class="form-control" id="usr">
                        </div>
                        <center><button  type="submit" class="btn btn-success">Update</button></center>
                    </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>


    </div>
@endsection
