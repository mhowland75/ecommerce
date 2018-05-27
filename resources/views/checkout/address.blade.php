@extends('layouts.app')
@section('content')
<div id="page">
  <div class="page-header">
    <h2>Select Address</h2>
  </div>
  <div class="row">
  @forelse ($addresss as $address)
  <a href="/checkout/address/{{ $address->id}}">
  <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-heading"><h3>{{ $address->firstline}} {{ $address->postcode}}</h3></div>
      <div class="panel-body">
        {{ $address->firstline}}<br>
        {{ $address->secondline}}<br>
        {{ $address->city}}<br>
        {{ $address->county}}<br>
        {{ $address->postcode}}<br>
        {{ $address->tel1}}<br>
        {{ $address->tel2}}<br><br>
      </div>
    </div>
  </div>
    </a>
    @empty
        <p>You currently have no address you need to create one before continuing.</p><br>
    @endforelse
  </div>
  <button type="button" class="btn btn-primary"><a href="address/create">Add Address</a></button>
</div>
@endsection
