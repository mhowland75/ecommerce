<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Auth;
use Session;
use Basket;
use Carbon\Carbon;
use App\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected function authenticated()
     {
       DB::table('ip_address')->insert(
         ['user_id' => Auth::id(), 'ip_address' => User::get_client_ip(), 'created_at'=> carbon::now()]
       );
       DB::table('users')->where('id',Auth::id())->update(['online'=> 1, 'last_login'=> Carbon::now()]);
       //gets users basket with there temp id
      $tempIdProducts = DB::table('basket')->where('user_id', Session::get('temp_id'))->get();
      $tempproductids = array();
      // enters all the product id of the user into an array.
      foreach ($tempIdProducts as $product) {
        $tempproductids[$product->product_id] = $product->product_size_id;
      }

      //gets all the authenticated users basket products.
      $userIdProducts = DB::table('basket')->where('user_id', Auth::id())->get();
      $userproductids = array();
      // enters all product id into an array
      foreach ($userIdProducts as $userproduct) {
        $userproductids[$userproduct->product_id] = $userproduct->product_size_id;
      }
      //arrays are compairs for duplicate products.
      $results = array_intersect($userproductids,$tempproductids);
      // if there are no duplicates the temp user id is updated.
      if(empty($results)){
        DB::table('basket')
           ->where('user_id', Session::get('temp_id'))
           ->update(['user_id' => Auth::id()]);
           Session::forget('temp_id');
      }
      else{
        // if there are duplicates the product quantity is added to the orginal quantity. only is there is suffisent stock levels.
        foreach($results as $product_id => $product_size_id){
        $user = DB::table('basket')->where([['user_id', '=',Auth::id() ],['product_id', '=', $product_id],['product_size_id', '=', $product_size_id]])->get();
         $temp =  DB::table('basket')->where([['user_id', '=', Session::get('temp_id')],['product_id', '=', $product_id],['product_size_id', '=', $product_size_id]])->get();
        $product =  DB::table('products')->where([['id', '=',$product_id ]])->get();
        print_r($temp);
        if($temp[0]->product_size_id == 0){
          $newQty = $user[0]->quantity + $temp[0]->quantity;
          if($newQty < $product[0]->stock){
            DB::table('basket')->where([['user_id', '=',Auth::id() ],['product_id', '=', $product_id]])->update(['quantity' => $newQty]);
          }
          DB::table('basket')->where([['user_id', '=',Session::get('temp_id') ],['product_id', '=', $product_id]])->delete();
        }
        elseif($temp[0]->product_size_id > 0){
          $tempProductSize = DB::table('basket')->where([['product_size_id',$temp[0]->product_size_id],['user_id',Session::get('temp_id')],['product_id',$temp[0]->product_id]])->get();
          $userProductSize = DB::table('basket')->where([['product_size_id',$user[0]->product_size_id],['user_id',Auth::id()],['product_id',$user[0]->product_id]])->get();
          $productSizeQty = DB::table('product_sizes')->where('id',$user[0]->product_size_id)->get();
          $userProductSize[0]->quantity;
          $newQty = $userProductSize[0]->quantity + $tempProductSize[0]->quantity;
          //return $user[0]->product_size_id;
          if($newQty < $productSizeQty[0]->stock){
            DB::table('basket')->where([['user_id', '=',Auth::id() ],['product_id', '=', $product_id],['product_size_id','=',$user[0]->product_size_id ]])->update(['quantity' => $newQty]);

          }
          DB::table('basket')->where([['user_id', '=',Session::get('temp_id') ],['product_id', '=', $product_id],['product_size_id','=',$temp[0]->product_size_id ]])->delete();
        }

        }
      }

     }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function logout() {
      Session::forget('delivery_method');
      Session::forget('address_id');
      DB::table('users')->where('id',Auth::id())->update(['online'=> '0','last_logout'=>Carbon::now() ]);
      Auth::logout();
      return redirect('/home');
    }
}
