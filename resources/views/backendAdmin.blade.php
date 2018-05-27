@extends('layouts.backend')
@section('content')
<div id="page">
  <a href="orders/orders?sort=Payment+Received">My Orders</a><br>
  <a href="products/create">Add Products</a><br>
  <a href="products/view">My Products</a><br>
  <a href="users">My Customers</a><br>
  <a href="reviews">Review Management</a><br>
  <a href="administrator/onlineUsers">Online Users</a><br>
  <a href="/administrator/create">Add administrator</a><br>
  <a href="/administrator/manage">Manage Privileges</a>

</div>
@endsection
