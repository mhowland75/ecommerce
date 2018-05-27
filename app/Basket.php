<?php

namespace App;
use Product;
use Auth;
use Session;
use DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
class Basket extends Model
{
  use SoftDeletes;
  protected $fillable = ['name', 'price', 'stock','location','description', 'image', 'weight','langth','width','height'];
  protected $table = 'basket';
  protected $dates = ['deleted_at'];

  public  static function product(){
    return $this->belongsTo(Product::class, 'product_id');
  }
  public static function basketTotal(){
    if(Auth::check()){
      $basket = DB::table('basket')->where('user_id',Auth::id())->get();
      $basketTotal = 0;
      foreach ($basket as $item) {
        if($item->product_size_id == 0){
          $product = DB::table('products')->where('id',$item->product_id)->get();
          if($product[0]->sale_percentage > 0){
            $y = $product[0]->price/100 * $product[0]->sale_percentage;
            $y = $product[0]->price - $y;
            $product->price = $y;
          }

        }
        else{
          $product = DB::table('product_sizes')->where('id',$item->product_size_id)->get();
          if($product[0]->sale_percentage > 0){
            $y = $product[0]->price/100 * $product[0]->sale_percentage;
            $y = $product[0]->price - $y;
            $product[0]->price = $y;
          }
        }
          $basketTotal = $basketTotal + $item->quantity * $product[0]->price;
      }
    }
      else{
        $basket = DB::table('basket')->where('user_id', Session::get('temp_id'))->get();
        $basketTotal = 0;
        foreach ($basket as $item) {
          if($item->product_size_id == 0){
            $product = DB::table('products')->where('id',$item->product_id)->get();
            if($product[0]->sale_percentage > 0){
              $y = $product[0]->price/100 * $product[0]->sale_percentage;
              $y = $product[0]->price - $y;
              $product[0]->price = $y;
            }
          }
          else{
            $product = DB::table('product_sizes')->where('id',$item->product_size_id)->get();
            if($product[0]->sale_percentage > 0){
              $y = $product[0]->price/100 * $product[0]->sale_percentage;
              $y = $product[0]->price - $y;
              $product[0]->price = $y;
            }
          }
          //return $product;
          $basketTotal = $basketTotal + $item->quantity * $product[0]->price;
      }
    }
      return number_format($basketTotal,2);
  }

  public static function userBasketIdentification(){
    if(!Auth::id() && !Session::get('temp_id')){

      $id = rand(1000000,9999999);
      $x = 0;
      while($x <= 1){
        $xa = DB::table('basket')->where('user_id',$id)->get();
        if(empty($xa[0]->id) ){
          break;
        }
        $id = rand(1000000,9999999);
      }
        Session::put('temp_id', $id);

    }
    elseif(!Auth::id() && Session::get('temp_id')){
      $id = Session::get('temp_id');

    }
    elseif(Auth::id()){
      $id = Auth::id();
    }
    return $id;
  }

  public static function productExistsInBasket ($id,$product_id){
    $test = DB::table('basket')->where([['user_id', '=',$id ],['product_id', '=', $product_id]])->get();
    if(!empty($test[0]->id )){
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

  public static function stockCheck($user_id, $product_id, $qty){
    $stockLevel = DB::table('products')->where('id',$product_id)->get();
    $test = DB::table('basket')->where([['user_id', '=',$user_id ],['product_id', '=', $product_id]])->get();
    $newQty = $test[0]->quantity + $qty;
    if($newQty <= $stockLevel[0]->stock){
      return $newQty;
    }
    else{
      return 0;
    }
  }
}
