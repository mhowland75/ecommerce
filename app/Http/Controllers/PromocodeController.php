<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PromoCode;
use DB;
use App\Basket;
use Auth;
class PromocodeController extends Controller
{
  public function activatepromoCodeMethod($id){
    $status = DB::table('promo_code')->where('id',$id)->get();
    if($status[0]->active == 1){
      DB::table('promo_code')
            ->where('id', $id)
            ->update(['active' => 0, ]);
    }
    elseif($status[0]->active == 0){
      DB::table('promo_code')
            ->where('id', $id)
            ->update(['active' => 1, ]);
    }
      return redirect('/discounts/promoCode');
    }

    public function edit($id){
      $promoCode = DB::table('promo_code')->where('id',$id)->get();
      return view('discounts.promoCode.edit',compact('promoCode'));
    }
    public function update(Request $request, $id)
    {
      $this->validate($request, [
        'code' => 'required|max:20|min:10',
        'value' => 'required|numeric|between:0,9999.99',
        'discount_type' => 'required|max:1|min:1',
        'minimum_spend' => 'required|numeric|between:0,9999.99',
      ]);
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->code = $request->code;
        $promoCode->value = $request->value;
        $promoCode->discount_type = $request->discount_type;
        $promoCode->minimum_spend = $request->minimum_spend;
        $promoCode->update();
        return redirect('/discounts/promoCode');

    }

    public function store(request $request){
      $this->validate($request, [
        'code' => 'required|unique:promo_code|max:20|min:10',
        'value' => 'required|numeric|between:0,9999.99',
        'discount_type' => 'required|max:1|min:1',
        'minimum_spend' => 'required|numeric|between:0,9999.99',
    ]);
      if(!empty($request->code)){
        if($request->discount_type == '£'){
          if($request->value < $request->minimum_spend){
            $promoCode = new PromoCode;
            $promoCode->code = $request->code;
            $promoCode->value = $request->value;
            $promoCode->discount_type = $request->discount_type;
            $promoCode->minimum_spend = $request->minimum_spend;
            $promoCode->active = 0;
            $promoCode->save();
          }
          else{
            return redirect()->back()->withErrors(['The minimum spend needs to be grater than the discount value']);
          }
        }
        else{
          $promoCode = new PromoCode;
          $promoCode->code = $request->code;
          $promoCode->value = $request->value;
          $promoCode->discount_type = $request->discount_type;
          $promoCode->minimum_spend = $request->minimum_spend;
          $promoCode->active = 0;
          $promoCode->save();
        }

      }
      return redirect('/discounts/promoCode');
    }
    public function promoCode(){

      $promoCodes = DB::table('promo_code')->get();
        return view('discounts.promoCode.promoCode',compact('promoCodes'));
      }

    public function PromoCodeValidation(request $request){
        $promoCodes = DB::table('promo_code')->where([['active',1],['code',$request->promoCode]])->get();

      if(!empty($promoCodes[0]->id)){
        $redeemed = DB::table('promo_code_redeem')->where([['user_id',Auth::id()],['code_id',$promoCodes[0]->id]])->count();
        if($redeemed > 0){
            return redirect()->back()->withErrors(['You have already used this promo code.']);
        }
        $basketTotal = Basket::basketTotal();
        if($basketTotal > $promoCodes[0]->minimum_spend){
          if($promoCodes[0]->discount_type == '%'){
            $discount = $basketTotal/100 * $promoCodes[0]->value;
            $newBasketTotal = $basketTotal - $discount;
            session()->put('promoCodeId', $promoCodes[0]->id);
            return redirect('/checkout/payment')->with( [ 'newBasketTotal' => $newBasketTotal, 'discount'=> $discount ] );
          }
          if($promoCodes[0]->discount_type == '£'){
            $newBasketTotal = $basketTotal -  $promoCodes[0]->value;
            if($newBasketTotal < 0){
              $newBasketTotal = 0.01;
            }
            session()->put('promoCodeId', $promoCodes[0]->id);
            return redirect('/checkout/payment')->with( [ 'newBasketTotal' => $newBasketTotal, 'discount'=> $promoCodes[0]->value ] );
          }
        }
        return redirect()->back()->withErrors(['the minimum spend to use this promo code is £'.$promoCodes[0]->minimum_spend.'.']);
      }
      return redirect()->back()->withErrors(['You have entered an invalid promo code.']);
    }


}
