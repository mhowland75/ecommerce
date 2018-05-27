@extends('layouts.backend')
@section('content')
<div id="page">
  <div class="row">
   <div class="col-sm-6">
     <div class="panel panel-default">
       <div class="panel-heading">
         <h2>Delivery Methods</h2>
     </div>
       <div class="panel-body">
         <table class="table table-striped">
         <thead>
         <tr>
           <th>Name</th>
           <th>Price</th>
           <th>ETA</th>
           <th>Chargeless</th>
           <th>Notes</th>
         </tr>
       </thead>
         <tbody>
     @forelse ($deliveryMethods as $delivery)
       <tr>
         <td>{{$delivery->name}}</td>
         <td>£{{$delivery->price}}</td>
         <td>{{$delivery->eta}}</td>
         <td>£{{$delivery->chargeless}}</td>
         <td>{{$delivery->notes}}</td>
         <td><a  data-toggle="tooltip" title="Edit Product" href="/delivery/updateDeliveryMethod/{{$delivery->id}}"><i style="font-size:20px" class="ion-edit"></i></a></td>
         <td><a  data-toggle="tooltip" title="Product visability" href="/delivery/activateDeliveryMethod/{{$delivery->id}}"><?php if($delivery->active == 1){echo'<i style="font-size:20px" class="ion-eye"></i>';}else{echo'<i style="font-size:20px" class="ion-eye-disabled"></i>';} ?></a></td>
       </tr>
        @empty
       @endforelse
     </table>
       </div>
     </div>
   </div>

   <div class="col-sm-6">
     <div class="panel panel-default">
      <div class="panel-heading"><center><h2>Add Delivery Method</h2></center></div>
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
        <form class="form-horizontal" method="GET" action='/delivery/addDeliveryMethod' >
            {{ csrf_field()}}
        <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="usr">Name:</label>
            <input name="name" type="text" class="form-control" id="usr">
        </div>
        <div class="form-group">
            <label for="usr">Price:</label>
            <input name="price" type="text" class="form-control" id="usr">
        </div>
        <div class="form-group">
            <label for="usr">chargeless:</label>
            <input name="chargeless" type="text" class="form-control" id="usr">
        </div>
        <div class="form-group">
            <label for="usr">Delivery Time:</label>
            <input name="eta" type="text" class="form-control" id="usr">
        </div>
        <div class="form-group">
            <label for="usr">Notes:</label>
            <textarea name="notes" type="text" class="form-control" id="usr"></textarea>
        </div>
            <center><button  type="submit" class="btn btn-success">Create</button></center>
            </div>
        </form>

      </div>
    </div>
   </div>

 </div>



    </div>


</div>

@endsection
