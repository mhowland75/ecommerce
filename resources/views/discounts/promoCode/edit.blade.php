@extends('layouts.app')
@section('content')
<div id="page">
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">Edit Promo Code {{$promoCode[0]->code}}</div>
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
                  <form class="form-horizontal" method="GET" action='/discounts/promoCode/update/{{ $promoCode[0]->id}}' >
                      {{ csrf_field()}}
                      @if ($errors->any())
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                  <div class="col-md-10 col-md-offset-1">
                  <div class="form-group">
                      <label for="usr">Promo Code:</label>
                      <input name="code" type="text" class="form-control" id="usr"  value="{{ $promoCode[0]->code}}">
                  </div>
                  <div class="form-group">
                      <label for="usr">Value:</label>
                      <input name="value" type="text" class="form-control" id="usr" value="{{ $promoCode[0]->value}}">
                  </div>
                  <div class="form-group">
                   <label for="sel1">Discount Type:</label>
                   <select name="discount_type" class="form-control" id="sel1">
                     <option <?php if($promoCode[0]->discount_type == '%'){echo'selected="selected"';} ?>>%</option>
                     <option <?php if($promoCode[0]->discount_type == '£'){echo'selected="selected"';} ?>>£</option>
                   </select>
                  </div>
                  <div class="form-group">
                      <label for="usr">Minimum Spend:</label>
                      <input name="minimum_spend" type="text" class="form-control" id="usr" value="{{ $promoCode[0]->minimum_spend}}">
                  </div>
                      <center><button  type="submit" class="btn btn-success">Update Promo code</button></center>
                  </div>
                  </form>
            </div>
          </div>
        </div>
      </div>


</div>
@endsection
