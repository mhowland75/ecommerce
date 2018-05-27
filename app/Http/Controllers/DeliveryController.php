<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use App\Delivery;
//use App\Delivery;

class DeliveryController extends Controller
{

    public function addDeliveryMethod(Request $request){

      $this->validate($request, [
        'name' => 'required|unique:delivery|max:20|min:5',
        'price' => 'required|numeric|between:0,9999.99',
        'chargeless' => 'required|numeric|between:0,9999.99',
        'eta' => 'required',
    ]);
    $delivery = new Delivery;
    $delivery->name = $request->name;
    $delivery->price = $request->price;
    $delivery->chargeless = $request->chargeless;
    $delivery->eta = $request->eta;
    $delivery->notes = $request->notes;
    $delivery->active = 0;
    $delivery->save();

      return redirect('delivery/viewDeliveryMethod');
    }
    public function viewDeliveryMethods(){
      $deliveryMethods = DB::table('delivery')->get();

      return view('delivery.view',compact('deliveryMethods'));
    }
    public function updateDeliveryMethod($id){

      $delivery = DB::table('delivery')->where('id',$id)->get();

      return view('delivery.update',compact('delivery'));
    }
    public function update(request $request){
      $this->validate($request, [
        'name' => 'required|max:20|min:5',
        'price' => 'required|numeric|between:0,9999.99',
        'chargeless' => 'required|numeric|between:0,9999.99',
        'eta' => 'required',

    ]);
        $delivery = Delivery::findOrFail($request->id);
        $delivery->name = $request->name;
        $delivery->price = $request->price;
        $delivery->chargeless = $request->chargeless;
        $delivery->eta = $request->eta;
        $delivery->notes = $request->notes;
        $delivery->active = 0;
        $delivery->update();
            return redirect('/delivery/viewDeliveryMethod');
    }
    public function activateDeliveryMethod($id){
      $status = DB::table('delivery')->where('id',$id)->get();
      if($status[0]->active == 1){
        DB::table('delivery')
              ->where('id', $id)
              ->update(['active' => 0, ]);
      }
      elseif($status[0]->active == 0){
        DB::table('delivery')
              ->where('id', $id)
              ->update(['active' => 1, ]);
      }
        return redirect('delivery/viewDeliveryMethod');
      }

}
