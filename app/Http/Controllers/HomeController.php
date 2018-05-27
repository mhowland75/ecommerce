<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use App\Review;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')->get();
        foreach($products as $product){
          $sizes = DB::table('products')->where([['id',$product->id],['size_variation',1]])->get();
          if(!empty($sizes[0])){
          $productSizes = DB::table('product_sizes')->where([['product_id',$product->id],['active',1]])->orderBy('price', 'asc')->get();
          $productSizesSale = DB::table('product_sizes')->where([['product_id',$product->id],['active',1]])->orderBy('sale_percentage', 'desc')->get();
                $product->price = $productSizes[0]->price;
                $product->sale_percentage = $productSizesSale[0]->sale_percentage;
                $product->sale_price = 0;
          }else{
            if(!$product->sale_percentage == 0){
              $y = $product->price/100 * $product->sale_percentage;
              $y = $product->price - $y;
              $product->sale_price = $y;
            }
          }

           $x = array();
          $productImages = DB::table('product_images')->where('product_id',$product->id)->get();
          $stars = Review::starRating(Review::avgRating($product->id));
          $x['product'] = $product;
          $x['stars'] = $stars;
          $x['image'] = json_decode($productImages, true);
          $data[] = $x;
        }

        return view('home',compact('data'));
    }

    public function backendAdmin(){
      return view('backendAdmin');
    }
}
