@extends('layouts.backend')
@section('content')
<div id="page">
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading"><center><h2>Promo Codes</h2></center></div>
          <div class="panel-body">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Promo Code</th>
                  <th>Discount Type</th>
                  <th>Value</th>
                  <th>Minimum Spend</th>
                </tr>
              </thead>
              <tbody>
            @forelse ($promoCodes as $promoCode)
            <tr>
              <td>{{$promoCode->code}}</td>
              <td>{{$promoCode->discount_type}}</td>
              <td>{{$promoCode->value}}</td>
              <td>{{$promoCode->minimum_spend}}</td>
              <td><a  data-toggle="tooltip" title="Edit Product" href="/discount/promoCode/edit/{{$promoCode->id}}"><i style="font-size:20px" class="ion-edit"></i></a></td>
              <td><a  data-toggle="tooltip" title="Active Promo Code" href="/discount/activatePromoCode/{{$promoCode->id}}"><?php if($promoCode->active == 1){echo'<i style="font-size:20px" class="ion-eye"></i>';}else{echo'<i style="font-size:20px" class="ion-eye-disabled"></i>';} ?></a></td>
            </tr>
                  @empty
                      <p>No Promo Codes</p>
                  @endforelse
                </tbody>
              </table>

          </div>
        </div>
      </div>

      <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading"><center><h2>Add Promo Code</h2></center></div>
              <div class="panel-body">
                <form class="form-horizontal" method="GET" action='/discounts/promoCode/store' >
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
                    <input name="code" type="text" class="form-control" id="usr">
                </div>
                <div class="form-group">
                    <label for="usr">Value:</label>
                    <input name="value" type="text" class="form-control" id="usr">
                </div>
                <div class="form-group">
                 <label for="sel1">Discount Type:</label>
                 <select name="discount_type" class="form-control" id="sel1">
                   <option>%</option>
                   <option>£</option>
                 </select>
                </div>
                <div class="form-group">
                    <label for="usr">Minimum Spend:</label>
                    <input name="minimum_spend" type="text" class="form-control" id="usr">
                </div>
                    <center><button  type="submit" class="btn btn-success">Add Promo code</button></center>
                </div>
                </form>
              </div>
          </div>
        </div>
      </div>
</div>
@endsection
