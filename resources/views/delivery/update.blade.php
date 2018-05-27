@extends('layouts.backend')
@section('content')
<div id="page">
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading"><center><h2>Update Delivery Method {{ $delivery[0]->name}}</h2></center></div>
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
                <form class="form-horizontal" method="GET" action='/delivery/update' >
                    {{ csrf_field()}}
                <div class="col-md-10 col-md-offset-1">
                    <input type="hidden" name="id" value="{{ $delivery[0]->id}}">
                <div class="form-group">
                    <label for="usr">Name:</label>
                    <input name="name" type="text" class="form-control" id="usr" value="{{ $delivery[0]->name}}">
                </div>
                <div class="form-group">
                    <label for="usr">Price:</label>
                    <input name="price" type="text" class="form-control" id="usr" value="{{ $delivery[0]->price}}">
                </div>
                <div class="form-group">
                    <label for="usr">chargeless:</label>
                    <input name="chargeless" type="text" class="form-control" id="usr" value="{{ $delivery[0]->chargeless}}">
                </div>
                <div class="form-group">
                    <label for="usr">Delivery Time:</label>
                    <input name="eta" type="text" class="form-control" id="usr" value="{{ $delivery[0]->eta}}">
                </div>
                <div class="form-group">
                    <label for="usr">Notes:</label>
                    <input name="notes" type="text" class="form-control" id="usr" value="{{ $delivery[0]->notes}}">
                </div>
                    <center><button  type="submit" class="btn btn-success">Update</button></center>
                </form>
              </div>
          </div>
        </div>
      </div>
</div>
@endsection
