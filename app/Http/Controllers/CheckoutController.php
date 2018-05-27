<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Basket;

class CheckoutController extends Controller
{
    public function specialInstructions(request $request){
      Session::put('instructions', $request->instructions);
      return redirect('/checkout/payment');
    }

    public function address(){
      $addresss = DB::table('address')->where('user_id', Auth::id())->get();
      return view('checkout.address', compact('addresss'));
    }
    public function addressSave($id){
      if (!filter_var($id, FILTER_VALIDATE_INT) === false) {
        if(isset($id) && Address::addressVerification($id)){
          Session::put('address_id', $id);
          return redirect('/checkout/delivery');
        }
        else{
          return redirect('/checkout/address');
        }
      }
      else {
        return redirect('/checkout/address');
      }
  }
  public function deliveryMethod(){
    $basketTotal = Basket::basketTotal();
    $deliveryMethods = DB::table('delivery')->get();
    foreach($deliveryMethods as $deliveryMethod){
      if( $deliveryMethod->chargeless <= $basketTotal){
        if($deliveryMethod->chargeless > 0){
          $deliveryMethod->price = 0.00;
        }
      }
    }
    return view('/checkout/delivery',compact('deliveryMethods'));
    if(null !== Session::get('address_id') && Address::addressVerification(Session::get('address_id'))){
   }
   else{
     return redirect('/checkout');
   }
  }
  public function deliveryMethodSave($method){
    if (!filter_var($method, FILTER_VALIDATE_INT) === false) {

        Session::put('delivery_method', $method);
        return redirect('/checkout/payment');
    }
  }

  public function payment(){

    if(Session::get('delivery_method') && Session::get('address_id')){

      $delivery = DB::table('delivery')->where('id', Session::get('delivery_method'))->get();
      $address = DB::table('address')->where('id', Session::get('address_id'))->get();

      if(!empty(session()->get( 'newBasketTotal' ))){
        Session::keep(['newBasketTotal', 'discount']);
        $basketTotal = session()->get( 'newBasketTotal' );
        $discount = session()->get( 'discount' );
      }else{
        $basketTotal = Basket::basketTotal();
        $discount = 0;
      }
      if($delivery[0]->chargeless > 0){
        if($basketTotal > $delivery[0]->chargeless){
          $delivery[0]->price = 0;
        }
      }
      $orderTotal = $basketTotal + $delivery[0]->price;
      if(!empty(Session::get('instructions'))){
          $instructions = Session::get('instructions');
      }else{
        $instructions = '';
      }
      return view('/checkout/payment',compact('basketTotal','delivery','address','orderTotal','instructions','discount'));
    }
    else{
      return redirect('/checkout');
    }
}
  public function placeOrder(){
    if(!empty( Session::get('promoCodeId'))){
      $promoCodeId = Session::get('promoCodeId');
      $discount = Session::get('discount');
      DB::table('promo_code_redeem')->insert(['user_id'=> Auth::id(),'code_id'=>$promoCodeId]);
    }
    else{
      $promoCodeId = NULL;
      $discount = 0;
    }
    $orderId = DB::table('orders')->insertGetId(
      ['user_id' => Auth::id(), 'address_id' => Session::get('address_id'), 'delivery_type' => Session::get('delivery_method'), 'payment_type'=> 'PayPal','order_status'=>'Payment Received','promo_code_id'=>$promoCodeId,'discount'=>$discount,'created_at'=> Carbon::now()]
    );
    $baskets = DB::table('basket')->where('user_id', Auth::id())->get();

    foreach($baskets as $basket){
      $product = DB::table('products')->where('id',$basket->product_id )->get();
      DB::table('products')->where('id', $product[0]->id)->increment('times_ordered', 1);
      if($basket->product_size_id > 0){
        $productSize = DB::table('product_sizes')->where('id',$basket->product_size_id )->get();
        $sales_percentage = $productSize[0]->sale_percentage;
      }
      else{
        $product = DB::table('products')->where('id',$basket->product_id )->get();
        $sales_percentage = $product[0]->sale_percentage;
      }
      DB::table('orders_products')->insert([
      ['order_id'=> $orderId,'sale_percentage'=>$sales_percentage,'product_id'=>$basket->product_id,'product_size_id'=>$basket->product_size_id,'quantity'=>$basket->quantity, 'unit_price'=>$product[0]->price, 'picked'=>'0' ],
      ]);
      DB::table('basket')->where([
        ['user_id', '=', Auth::id()],
        ['product_id', '=', $basket->product_id],
        ])->delete();
    }
     session()->forget( 'newBasketTotal' );
     session()->forget( 'discount' );
    return redirect('/checkout/orderConfirmation');
  }
  public function orderConfirmation(){
    return view('/checkout/confirmation');
  }



}
