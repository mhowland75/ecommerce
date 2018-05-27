<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class OrdersController extends Controller
{
    public function index(){
      $orders = DB::table('orders')->where('user_id', Auth::id())->get();
      return view('orders.index', compact('orders'));
    }

    public function view($id){
      $products = DB::table('orders_products')->where('order_id', $id)->get();
      $orderProducts = array();
      foreach($products as $product){
        $x = array();
        $productDetails = DB::table('products')->where('id', $product->product_id)->get();
        $x['order'] = $product;
        $x['product'] = $productDetails;
        $orderProducts[] = $x;

      }
      //return $orderProducts;
      return view('orders.view', compact('orderProducts'));
    }
    public function orders(){
      if(!empty($_GET)){
        if(isset($_GET['update_status'])){
            $status = $_GET['update_status'];
        }else {
          $status = 0;
        }

        foreach($_GET as $order){
          DB::table('orders')
            ->where('id', $order)
            ->update(['order_status' => $status]);

        }
      }
      if(isset($_GET['sort'])){

        $orderStatus = $_GET['sort'];
      }
      else{
        $orderStatus = 'Payment Resived';
      }
      $orders = DB::table('orders')->where('order_status', $orderStatus)->get();
      $orderCount = DB::table('orders')->where('order_status', $orderStatus)->get()->count();
      return view('orders.orders', compact('orders','orderStatus','orderCount'));
    }

    public function picking($order_id){
      if (!empty($_GET)){
        foreach($_GET as $orderedproduct=>$val){

          DB::table('orders_products')
            ->where([['id',$orderedproduct],['order_id',$order_id]] )
            ->update(['picked' => 1]);
        }
        $order = DB::table('orders_products')->where([['order_id', $order_id],['picked', 0]])->get();

        if (empty($order[0])){

          DB::table('orders')
            ->where('id',$order_id )
            ->update(['order_status' => 'Picked']);
        }
      }
      $products = DB::table('orders_products')->where('order_id', $order_id)->get();
      $orderProducts = array();
      foreach($products as $product){
        $x = array();
        if($product->product_size_id > 0){
          $productInfo = DB::table('products')->where('id', $product->product_id)->get();
          $productSize = DB::table('product_sizes')->where('id', $product->product_size_id)->get();
        }else{
          $productInfo = DB::table('products')->where('id', $product->product_id)->get();
          $productSize = array();
        }
        $x['productInfo'] = $productInfo;
        $x['product_size'] = $productSize;
        $x['orderedproduct'] = $product;
        $orderProducts[]= $x;
      }
      //return $orderProducts;
      return view('orders.picking', compact('orderProducts','order_id'));
    }
    public function unpickOrder($order_id){
      $order = DB::table('orders_products')->where('order_id', $order_id)->get();
      foreach($order as $products){
        DB::table('orders_products')
          ->where([['id',$products->id],['order_id',$order_id]] )
          ->update(['picked' => 0]);
      }
      DB::table('orders')
        ->where('id',$order_id )
        ->update(['order_status' => 'Payment Received']);
      return redirect('orders/picking/'.$order_id);
    }
}
