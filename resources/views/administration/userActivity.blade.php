@extends('layouts.backend')
@section('content')
<div id="page">
  <table class="table">
      <thead>
        <tr>
          <th>URL</th>
          <th>Time</th>
        </tr>
      </thead>
      <tbody>
  @forelse ($usersactivity as $user)
  <tr>
    <td><a href="/{{$user->route}}">{{$user->route}}</a></td>
    <td>{{$user->created_at}}</td>
  </tr>
  @empty
  <h1>No Users Online</h1>
  @endforelse

</div>
@endsection
