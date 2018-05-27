<?php

namespace App\Http\Controllers;
use App\Basket;
use App\Product;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function basketUpdate(request $request){
      //return $_POST;
      if(isset($_POST)){

        $id = Basket::userBasketIdentification();
        foreach ($_POST as $basket_id => $qty) {

          if(is_int($basket_id)){
            if($qty <= 0){
              DB::table('basket')->where([['id', '=', $basket_id],['user_id','=',$id]])->delete();
            }
            else{
            $basket =  DB::table('basket')->where('id',$basket_id)->get();
              if($basket[0]->product_size_id == 0){
                $product = DB::table('products')->where('id',$basket[0]->product_id)->get();
                if($product[0]->stock < $qty){
                  $qty = $product[0]->stock;
                }
              }
              else{
                  $product = DB::table('product_sizes')->where('id',$basket[0]->product_size_id)->get();
                  if($product[0]->stock < $qty){
                    $qty = $product[0]->stock;
                  }
              }
              DB::table('basket')->where([['user_id', '=',$id ],['id', '=', $basket_id]])->update(['quantity' => $qty]);
            }

          }

        }
      }
      return redirect('/basket');
    }
    public function index()
    {
      //  return   $basket = DB::table('basket')->where('user_id',Auth::id())->get();
      if(Auth::id()){
        $id = Auth::id();
      }else{
        $id =  Session::get('temp_id');
      }
      $baskets = DB::table('basket')->where('user_id',$id)->get();
      $products = array();
      foreach($baskets as $product){
        if($product->product_size_id == 0){
          $x = DB::table('products')->where('id', $product->product_id )->get();
          if($x[0]->sale_percentage > 0){
            $y = $x[0]->price/100 * $x[0]->sale_percentage;
            $y = $x[0]->price - $y;
            $x->price = $y;
          }
        }else
        {
          $x = DB::table('products')->where('id', $product->product_id )->get();
          $x['size'] = DB::table('product_sizes')->where('id', $product->product_size_id )->get();
          if($x['size'][0]->sale_percentage > 0){
            $y = $x['size'][0]->price/100 * $x['size'][0]->sale_percentage;
            $y = $x['size'][0]->price - $y;
            $x['size'][0]->price = $y;
          }

        }

        $x[] = $product;
        $products[] = $x;
      }
      //return $products;
      $basketTotal = Basket::basketTotal();
      return view('basket.index', compact('products', 'baskets','basketTotal'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //return $request;
          $id = Basket::userBasketIdentification();
          if($request->size === 0 OR $request->size === NULL){
            //If the product has no size check to see if it already exist in the basket.
            $test = DB::table('basket')->where([['user_id', '=',$id ],['product_id', '=', $request->product_id]])->get();
            if(empty($test[0]->id)){
                //If the product dose not exist in the basket get stock level of the product.
                $stockLevel = DB::table('products')->where('id',$request->product_id)->get();
                //If the requested qty is grater than the current stock make the requested stock equal to the current product stock.
                if($stockLevel[0]->stock > 0){
                  if($request->quantity > $stockLevel[0]->stock){
                    $request->quantity = $stockLevel[0]->stock;
                  }
                    $basket = new Basket;
                    $basket->user_id = $id;
                    $basket->product_id = $request->product_id;
                    $basket->quantity = $request->quantity;
                  if($request->size === NULL){
                    $basket->product_size_id = 0;
                  }else{
                    $basket->product_size_id = $request->size;
                  }
                  $basket->save();
                }

            }
            else{
              //If the product already exits in the basket update the quantity accouding to product stock level.
                  $stockLevel = DB::table('products')->where('id',$request->product_id)->get();
                  if($stockLevel[0]->stock > 0){
                    $basketProductTotalQty = $test[0]->quantity + $request->quantity;
                    if($basketProductTotalQty >= $stockLevel[0]->stock){
                      //if the requested qty is grater than the product stock only avalible stock will be added to the basket.
                      $request->quantity = $stockLevel[0]->stock;
                    }
                    DB::table('basket')->where([['user_id', '=',$id ],['product_id', '=', $request->product_id]])->update(['quantity' => $request->quantity ]);
                  }
            }
            return redirect('products/'.$request->product_id);
          }
          else{
            $test = DB::table('basket')->where([['user_id',$id],['product_id',$request->product_id],['product_size_id',$request->size]])->get();
            if(empty($test[0])){
              $stockLevel = DB::table('product_sizes')->where('id',$request->size)->get();
              if($stockLevel[0]->stock > 0){
                if($request->quantity > $stockLevel[0]->stock){
                  $request->quantity = $stockLevel[0]->stock;
                }
                $basket = new Basket;
                $basket->user_id = $id;
                $basket->product_id = $request->product_id;
                $basket->quantity = $request->quantity;
                if($request->size === NULL){
                  $basket->product_size_id = 0;
                }else{
                  $basket->product_size_id = $request->size;
                }
                $basket->save();
            }
            }
            else{
              $stockLevel = DB::table('product_sizes')->where('id',$request->size)->get();
              if($stockLevel[0]->stock > 0){
                $basketQty = DB::table('basket')->where([['user_id',$id],['product_id',$request->product_id],['product_size_id',$request->size]])->get();
                $basketProductTotalQty = $basketQty[0]->quantity + $request->quantity;
                if($basketProductTotalQty >= $stockLevel[0]->stock){
                  //if the requested qty is grater than the product stock only avalible stock will be added to the basket.
                  $request->quantity = $stockLevel[0]->stock;
                }
                  DB::table('basket')->where([['user_id', '=',$id ],['product_id', '=', $request->product_id],['product_size_id', '=',$request->size]])->update(['quantity' => $request->quantity]);
              }
          }
            return redirect('products/'.$request->product_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
    public function removeBasketItem($id){
    if(Auth::check()){
      $test = DB::table('basket')->where([['id', $id],['user_id',Auth::id()]])->get();
      if(!empty($test[0]->id)){
        $user_id = Auth::id();
        DB::table('basket')->where([['id', '=', $id],['user_id','=',$user_id]])->delete();
        return redirect('/basket');
      }
      else{
        return redirect()->back();
      }

    }elseif(!empty(Session::get('temp_id'))){
      $test = DB::table('basket')->where([['id', $id],['user_id',Session::get('temp_id')]])->get();
      if(!empty($test[0]->id)){
        $user_id = Session::get('temp_id');
        DB::table('basket')->where([['id', '=', $id],['user_id','=',$user_id]])->delete();
        return redirect('/basket');
      }
      else{
        return redirect()->back();
      }
    }
    else{
      return redirect()->back();
    }

    }
}
