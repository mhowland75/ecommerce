@extends('layouts.app')
@section('content')
<div id="page">
  <div class="row">

  @forelse ($addresss as $address)
  <div class="col-sm-4">
    <div class="panel panel-default">
    <div class="panel-heading">  {{ $address->firstline}}</div>
    <div class="panel-body">
      {{ $address->firstline}}<br>
      {{ $address->secondline}}<br>
      {{ $address->city}}<br>
      {{ $address->county}}<br>
      {{ $address->postcode}}<br>
      {{ $address->tel1}}<br>
      {{ $address->tel2}}<br><br>
      <center><a href="/address/{{ $address->id}}/edit"><button type="button" class="btn btn-primary">Update Address</button></a><br><br>
      <form action="/address/delete/{{ $address->id}}" method="post" >
        {{ csrf_field()}}
        <button type="submit" class="btn btn-primary">Delete</button>
      </form>
    </center>
    </div>
  </div>
  </div>
    @empty
        <p>No address</p>

    @endforelse

  </div>
    <a href="/address/create"><button type="button" class="btn btn-primary">Create Address</button></a><br>
</div>
@endsection
