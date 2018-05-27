@extends('layouts.app')
@section('content')
<div id="page">
  <?php $orderTotal = 0;?>
  @forelse ($orderProducts as $product)
    <?php
    $productTotal = $product['order']->unit_price * $product['order']->quantity;
    $orderTotal = $orderTotal + $productTotal;
    ?>
    {{$product['product'][0]->name}}
    {{$product['order']->unit_price}}
    {{$product['order']->quantity}}
    {{ $productTotal }}
    <br>

    @empty
        <p>There are no items in your basket.</p>
    </div>
    @endforelse
    <br>
    <?php echo $orderTotal;?>
</div>
@endsection
