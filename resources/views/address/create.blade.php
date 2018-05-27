@extends('layouts.app')
@section('content')
<div id="page">
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">Add Address</div>
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
              <form class="form-horizontal" method="POST" action='/address'>
                  {{ csrf_field()}}

                <div class="col-md-8 col-md-offset-2">
                  <div class="form-group">
                      <label for="usr">First line:</label>
                      <input name="firstline" type="text" class="form-control" id="usr">
                  </div>
                  <div class="form-group">
                      <label for="usr">Secondline line:</label>
                      <input name="secondline" type="text" class="form-control" id="usr">
                  </div>
                  <div class="form-group">
                      <label for="usr">City:</label>
                      <input name="city" type="text" class="form-control" id="usr">
                  </div>
                  <div class="form-group">
                      <label for="usr">County:</label>
                      <input name="county" class="form-control" rows="5" id="comment"></input>
                  </div>
                  <div class="form-group">
                      <label for="usr">Postcode:</label>
                      <input name="postcode" class="form-control" rows="5" id="comment"></input>
                  </div>
                  <div class="form-group">
                      <label for="usr">Phone Number:</label>
                      <input name="tel1" class="form-control" rows="5" id="comment"></input>
                  </div>
                  <div class="form-group">
                      <label for="usr">Mobile Number:</label>
                      <input name="tel2" class="form-control" rows="5" id="comment"></input>
                  </div>


                      <center><button  type="submit" class="btn btn-success">Add Address</button></center>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
