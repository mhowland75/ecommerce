<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Basket;
use App\Review;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Storage;
class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */#
     public function updateProductSize(request $request){
       DB::table('product_sizes')->where('id', $request->productSize_id)->update(['size' => $request->size, 'price'=> $request->price, 'stock'=> $request->stock, 'low_stock_level'=>$request->low_stock_level, 'location'=>$request->location, 'sale_percentage'=>$request->sale_percentage ]);
       return redirect()->back();
     }
     public function editProductSize($id){
       $productSize =  DB::table('product_sizes')->where('id',$id)->get();
       $product = DB::table('products')->where('id',$productSize[0]->product_id)->get();
       return view('products.editProductSize',compact('productSize','product'));
     }
     public function ajaxSize($id){
        $productSizeDetails = DB::table('product_sizes')->where('id',$id)->get();
        if($productSizeDetails[0]->stock > 10){
          $productSizeDetails[0]->stock = 'More than 10 in Stock';
        }
      return  '<h4>Stock: '.$productSizeDetails[0]->stock.'</h4>';
     }
     public function manageProductSize($product_id){
      $product = DB::table('products')->where('id',$product_id)->get();
      $productSizes = DB::table('product_sizes')->where('product_id',$product_id)->get();
      return view('products.addProductSize', compact('product_id','productSizes','product'));
     }
     public function addProductSize(request $request){
       DB::table('product_sizes')->insert(
      [
        'product_id' => $request->product_id,
        'size' => $request->size,
        'price' => $request->price,
        'stock' => $request->stock,
        'low_stock_level' => $request->low_stock_level,
        'location' => $request->location,
        'active' => 0,
        'sale_percentage' => $request->sale_percentage,
      ]
      );
      DB::table('products')
            ->where('id', $request->product_id)
            ->update(['size_variation' => 0]);
            return redirect()->back();
     }
     public function activateProductSize($id){
       $status = DB::table('product_sizes')->where('id',$id)->get();
       if($status[0]->active == 1){
         DB::table('product_sizes')
               ->where('id', $id)
               ->update(['active' => 0, ]);
         $test = DB::table('product_sizes')->where([['id',$id],['active',1]])->get();
         if(empty($test[0]->id)){
            DB::table('products')->where('id', $status[0]->product_id)->update(['size_variation' => 0]);
         }
       }
       elseif($status[0]->active == 0){
         DB::table('product_sizes')
               ->where('id', $id)
               ->update(['active' => 1, ]);
                 DB::table('products')->where('id', $status[0]->product_id)->update(['size_variation' => 1]);
       }
         return redirect('/products/size/'.$status[0]->product_id);
     }
     public function activateProduct($id){
       $status = DB::table('products')->where('id',$id)->get();
       if($status[0]->active == 1){
         DB::table('products')
               ->where('id', $id)
               ->update(['active' => 0, ]);
       }
       elseif($status[0]->active == 0){
         DB::table('products')
               ->where('id', $id)
               ->update(['active' => 1, ]);
       }
         return redirect('/products/view');
     }
     public function timesViewed(){
      $productViews = DB::table('products')->orderBy('times_viewed', 'desc')->get();
      $productOrdereds = DB::table('products')->orderBy('times_ordered', 'desc')->get();
      return view('products.timesViewed',compact('productViews','productOrdereds'));
     }
     public function lowStock(request $request){
       if($request->productlocation && $request->qty){
        $product = DB::table('products')->where('location',$request->productlocation)->get();
        $productSize = DB::table('product_sizes')->where('location',$request->productlocation)->get();
        if(!empty($product[0]->id)){

            $operator = substr($request->qty,1);
            if($operator = '+'){
              $sum = $product[0]->stock + $request->qty;
            }
            elseif($operator = '-'){
                $sum = $product[0]->stock - $request->qty;
            }
             DB::table('products')
                ->where('location', $request->productlocation)
                ->update(['stock' => $sum]);
           }
           elseif(!empty($productSize[0]->id)){

             $operator = substr($request->qty,1);
             if($operator = '+'){
               $sum = $productSize[0]->stock + $request->qty;
               if($sum < 0){
                 $sum = 0;
               }
             }
             elseif($operator = '-'){
                 $sum = $productSize[0]->stock - $request->qty;
                 if($sum < 0){
                   $sum = 0;
                 }
             }
              DB::table('product_sizes')
                 ->where('location', $request->productlocation)
                 ->update(['stock' => $sum]);
            }else{
              return redirect()->back()->withErrors(['This location is dose not exist please try again']);
            }
              return redirect()->back();
          }
            //$lowStockProducts = DB::table('products')->whereColumn([['stock', '<', 'low_stock_level']])->where('size_variation',0)->orderBy('stock', 'asc')->get();
            $searchError = 0;
            if(!empty($request->search)){
              $search = $request->search;
                  $products=array();
                  $x = DB::table('products')->where('name', 'Like', '%'.$request->search.'%')->get();
                  foreach($x as $y){
                    $products[] = $y;
                  }
                  $x = DB::table('products')->where('primary_category', 'Like', '%'.$request->search.'%')->get();
                  //if x is empty skip array addition
                  if(!empty($x[0]->id)){
                    //loop though x
                    foreach($x as $y){
                      //if products is empty skip entery check
                      if(!empty($products[0]->id)){
                        foreach($products as $product){
                          //loop though products if product id is found in the db call
                            if($product->id == $y->id){
                              break;
                            }
                            else{
                              $products[] = $y;
                              break;
                            }
                        }
                      }
                      else{
                        $products[] = $y;
                      }
                    }
                  }

                  $x = DB::table('products')->where('secondary_category', 'Like', '%'.$request->search.'%')->get();
                  //if x is empty skip array addition
                  if(!empty($x[0]->id)){
                    //loop though x
                    foreach($x as $y){
                      //if products is empty skip entery check
                      if(!empty($products[0]->id)){
                        foreach($products as $product){
                          //loop though products if product id is found in the db call
                            if($product->id == $y->id){
                              break;
                            }
                            else{
                              $products[] = $y;
                              break;
                            }
                        }
                      }
                      else{
                        $products[] = $y;
                      }
                    }
                  }


                  if(empty($products[0]->id)){
                    $products = DB::table('products')->paginate(50);
                    $searchError = 1;
                  }
            }else{
              $search = '';

              $products = DB::table('products')->get();
            }

            $lowStockProducts = array();
            foreach($products as $product){
              if($product->size_variation == 1){
                $productSizes = DB::table('product_sizes')->where('product_id', $product->id)->get();
                foreach($productSizes as $productSize){

                  if($productSize->stock < $productSize->low_stock_level){
                    $productSize->name = $product->name;
                    $productSize->primary_category = $product->primary_category;
                    $productSize->secondary_category = $product->secondary_category;
                    $lowStockProducts[] = $productSize;
                  }
                }
              }
              elseif($product->stock < $product->low_stock_level){
                  $lowStockProducts[] = $product;
                }
            }
          //  return $lowStockProducts;
        $lowStockProductsCount = DB::table('products')->whereColumn([['stock', '<', 'low_stock_level']])->count();
        $lowStockProductsCountSizes = DB::table('product_sizes')->whereColumn([['stock', '<', 'low_stock_level']])->count();
        $lowStockProductsCount = $lowStockProductsCount + $lowStockProductsCountSizes;
        $outOfStockProductsCount = DB::table('products')->where('stock',0)->count();
        $outOfStockProductsCountSizes = DB::table('product_sizes')->where('stock',0)->count();
        $outOfStockProductsCount = $outOfStockProductsCount + $outOfStockProductsCountSizes;
        return view('products.lowStock', compact('searchError','search','outOfStockProductsCount','lowStockProducts','lowStockProductsCount'));
     }
     public function uploadProductCSV(){
       $file = file_get_contents("products.csv");
       $data = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $file));
       //echo'<pre>';
      // print_r($data);
       foreach($data as $line){
         if(!empty($line[1])){
           DB::table('products')

              ->insert(['name' => $line['1'],
              'primary_category' => $line['2'],
              'secondary_category' => $line['3'],
              'price' => $line['4'],
              'stock' => $line['5'],
              'low_stock_level' => $line['6'],
              'location' => $line['7'],
              'description' => $line['8'],
              'image' => $line['9'],
              'weight' => $line['10'],
              'langth' => $line['11'],
              'width' => $line['12'],
              'height' => $line['13'],

            ]);
         }
       }
       echo'<pre>';
       return $data;
     }
     public function crateProductCSV(){

        $list = DB::table('products')->get();

        $fp = fopen('products.csv', 'w');
        foreach ($list as $fields) {
            if( is_object($fields) )
                $fields = (array) $fields;
            fputcsv($fp, $fields);
        }

        fclose($fp);
     }
     public function productSearch(Request $request){
       // get the search term
        $text = $request->input('text');
        if(strlen($text) == 0){
          return 'undefined';
          //$products = (object) array(0 => '');
        }
        elseif(strlen($text) > 0 && strlen($text) < 2){
          return 'minimum 3 characters';
        }
        elseif(strlen($text) > 2){

         $products = DB::table('products')->where('name', 'Like', '%'.$text.'%')->count();

          if($products == '0'){
            return 'no results';
          }else{
            $products = DB::table('products')->where('name', 'Like', '%'.$text.'%')->get();
            //$products[0]->image = 1;
            foreach ($products as $product) {
              $images =  DB::table('product_images')->where('product_id',$product->id)->get();
              $product->image = $images[0]->image;
            }
          }

        }

        return response()->json($products);

     }

     public function productDetailedSearch(Request $request){
       //return $request;
       $products = DB::table('products')
              ->where('name', 'like', '%'.$request->txtSearch.'%')
              ->get();
               foreach($products as $product){
                   $product->image = Storage::url($product->image);
               }
               return view('products.index', compact('products'));
     }
    public function index($primary_category,$secondary_category)
    {
      $sort = 'none';
      if(!empty($_GET['sort'])){
        if($_GET['sort'] == 'Sort By:'){
          $products = DB::table('products')->where([['primary_category',$primary_category],['secondary_category', $secondary_category],['active',1]])->get();
        }
        if($_GET['sort'] == 'Price: Low to High'){
          $products = DB::table('products')->where([['primary_category',$primary_category],['secondary_category', $secondary_category],['active',1]])->orderBy('price', 'asc')->get();
        }
        elseif($_GET['sort'] == 'Price: High to Low'){
            $products = DB::table('products')->where([['primary_category',$primary_category],['secondary_category', $secondary_category],['active',1]])->orderBy('price', 'desc')->get();
        }
        elseif($_GET['sort'] == 'Popularity'){
            $products = DB::table('products')->where([['primary_category',$primary_category],['secondary_category', $secondary_category],['active',1]])->orderBy('times_ordered', 'desc')->get();
        }
        elseif($_GET['sort'] == 'Average Rating'){
            $products = DB::table('products')->where([['primary_category',$primary_category],['secondary_category', $secondary_category],['active',1]])->get();
            foreach($products as $product){
              $reviews = DB::table('reviews')->where('product_id',$product->id)->get();
              if(!empty($reviews[0]->id)){
                $i = 0;
                $productReviewsTotal = 0;
                foreach( $reviews as $review){
                  $productReviewsTotal = $productReviewsTotal + $review->rating;
                  $i++;
                }
                $xs = $productReviewsTotal/ $i;
                DB::table('products')
                ->where('id', $product->id)
                ->update(['average_rating' => $xs]);
              }
              else{
                DB::table('products')
                ->where('id', $product->id)
                ->update(['average_rating' => 0]);
              }
            }
              $products = DB::table('products')->where([['primary_category',$primary_category],['secondary_category', $secondary_category],['active',1]])->orderBy('average_rating', 'desc')->get();
        }
        $sort = $_GET['sort'];
      }
      else{
          $products = DB::table('products')->where([['primary_category',$primary_category],['secondary_category', $secondary_category],['active',1]])->get();
      }

         $data = array();
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
        // return $data;
      return view('products.index', compact('data','primary_category','secondary_category','sort'));
    }

    public function view(request $request){
      $searchError = 0;
      $totalProducts = DB::table('products')->count();
      $activeProducts = DB::table('products')->where('active',1)->count();
      $inactiveProducts = DB::table('products')->where('active',0)->count();
      $lowStockProducts = DB::table('products')->whereColumn([['stock', '<', 'low_stock_level'],])->count();
      $outOfStockProducts = DB::table('products')->where('stock',0)->count();
      $saleProducts =  DB::table('products')->where('sale_percentage','>',0)->count();
      $saleSizeProducts =  DB::table('product_sizes')->where('sale_percentage','>',0)->count();
      $saleItems = $saleProducts + $saleSizeProducts;
      $sizeVariation = DB::table('products')->where('size_variation',1)->count();
      $totalSizeVariations =  DB::table('product_sizes')->count();
      $totalProductViews = 0;

      if(!empty($request->search)){
        $search = $request->search;
            $products=array();
            $x = DB::table('products')->where('name', 'Like', '%'.$request->search.'%')->get();
            foreach($x as $y){
              $products[] = $y;
            }
            $x = DB::table('products')->where('primary_category', 'Like', '%'.$request->search.'%')->get();
            //if x is empty skip array addition
            if(!empty($x[0]->id)){
              //loop though x
              foreach($x as $y){
                //if products is empty skip entery check
                if(!empty($products[0]->id)){
                  foreach($products as $product){
                    //loop though products if product id is found in the db call
                      if($product->id == $y->id){
                        break;
                      }
                      else{
                        $products[] = $y;
                        break;
                      }
                  }
                }
                else{
                  $products[] = $y;
                }
              }
            }

            $x = DB::table('products')->where('secondary_category', 'Like', '%'.$request->search.'%')->get();
            //if x is empty skip array addition
            if(!empty($x[0]->id)){
              //loop though x
              foreach($x as $y){
                //if products is empty skip entery check
                if(!empty($products[0]->id)){
                  foreach($products as $product){
                    //loop though products if product id is found in the db call
                      if($product->id == $y->id){
                        break;
                      }
                      else{
                        $products[] = $y;
                        break;
                      }
                  }
                }
                else{
                  $products[] = $y;
                }
              }
            }

            $x = DB::table('products')->where('id', 'Like', '%'.$request->search.'%')->get();
            //if x is empty skip array addition
            if(!empty($x[0]->id)){
              //loop though x
              foreach($x as $y){
                //if products is empty skip entery check
                if(!empty($products[0]->id)){
                  foreach($products as $product){
                    //loop though products if product id is found in the db call
                      if($product->id == $y->id){
                        break;
                      }
                      else{
                        $products[] = $y;
                        break;
                      }
                  }
                }
                else{
                  $products[] = $y;
                }
              }
            }
            $x = DB::table('products')->where('location', 'Like', '%'.$request->search.'%')->get();
            //if x is empty skip array addition
            if(!empty($x[0]->id)){
              //loop though x
              foreach($x as $y){
                //if products is empty skip entery check
                if(!empty($products[0]->id)){
                  foreach($products as $product){
                    //loop though products if product id is found in the db call
                      if($product->id == $y->id){
                        break;
                      }
                      else{
                        $products[] = $y;
                        break;
                      }
                  }
                }
                else{
                  $products[] = $y;
                }
              }
            }

            if(empty($products[0]->id)){
              $products = DB::table('products')->paginate(50);
              $searchError = 1;
            }
      }else{
        $search = '';
        $products = DB::table('products')->paginate(50);
      }

      foreach($products as $product){
          $totalProductViews = $totalProductViews + $product->times_viewed;
        $x = array();
         $productImages = DB::table('product_images')->where('product_id',$product->id)->get();
         $x['product'] = $product;
         $x['image'] = json_decode($productImages, true);
         $data[] = $x;
      }
      //return $data;
      return view('products.view', compact('searchError','totalProductViews','saleSizeProducts','totalSizeVariations','data','search','searchBy','totalProducts','activeProducts','inactiveProducts','lowStockProducts','outOfStockProducts','saleItems','sizeVariation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProduct(Request $request)
    {

      $this->validate($request, [
        'name' => 'required|unique:products|max:50|min:3',
        'primary_category' => 'required|max:20|min:3',
        'secondary_category' => 'required|max:20|min:3',
        'price' => 'required|numeric|between:0,9999.99',
        'stock' => 'required|numeric|between:0,9999',
        'low_stock_level' => 'required|numeric|between:0,9999',
        'location' => 'required|unique:products',
        'description' => 'required|max:5000|min:20',
        'sale_percentage' => 'required|numeric|between:0,100',

    ]);
    $product = new Product;
    $product->name = $request->name;
    $product->primary_category = $request->primary_category;
    $product->secondary_category = $request->secondary_category;
    $product->price = $request->price;
    $product->stock = $request->stock;
    $product->low_stock_level = $request->low_stock_level;
    $product->location = $request->location;
    $product->description = $request->description;
    $product->active = 0;
    $product->times_viewed = 0;
    $product->times_ordered = 0;
    $product->size_variation = 0;
    $product->sale_percentage = $request->sale_percentage;
    $product->weight = $request->weight;
    $product->langth = $request->langth;
    $product->width = $request->width;
    $product->height = $request->height;

    $product->save();
    return redirect('/products/images/manage/'.$product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if(Auth::check()){
          $viewedProducts = DB::table('product_views')->where('user_id', Auth::id())->get();
          $viewproductinfo = array();
          $x = 0;
          foreach ($viewedProducts as $product) {
            if($x < 5){
              $viewproductinfo[] =  DB::table('products')->where([['id',$product->product_id],['active',1]])->get();
            }
            $x++;
          }

          $productExists = DB::table('product_views')->where([['user_id', Auth::id()],['product_id', $id]])->get();
          /*
          if(empty($productExists[0]->id)){
            DB::table('product_views')->insert(
              ['user_id' => Auth::id(), 'product_id' => $id,'created_at' => carbon::now()]);
          }
          */
        }
        else{
            $viewproductinfo = array();
        }

        DB::table('products')->where('id', $id)->increment('times_viewed', 1);
        $productImages = DB::table('product_images')->where('product_id',$id)->get();
        $reviews = DB::table('reviews')->where([['product_id',$id],['active', 1]])->get();
        if(!empty($reviews[0])){
          $x = array();
          foreach($reviews as $review){
            $review->rating = Review::starRating($review->rating);
            $user = DB::table('users')->where('id',$review->user_id)->get();
            $x['review'] = $review;
            $x['user'] = $user;
            $data[] = $x;
          }
        }else{
          $data = array();
        }

        //return $data;
        $product = Product::findOrFail($id);
        if($product->size_variation == 1){
          $productSizes = DB::table('product_sizes')->where([['product_id',$product->id],['active',1]])->get();
          foreach($productSizes as $productSize){
            if(!$productSize->sale_percentage == 0){
              $y = $productSize->price/100 * $productSize->sale_percentage;
              $y = $productSize->price - $y;
              $productSize->sale_price = $y;
            }else{
              $productSize->sale_price = 0;
            }
          }
        }
        else{$productSizes = array();}
        if($product->sale_percentage > 0){
          $y = $product->price/100 * $product->sale_percentage;
          $y = $product->price - $y;
          $product->sale_price = $y;
        }
        //return $productSizes;
        //$imageURL = Storage::url($product->image);
        $reviewCount = DB::table('reviews')->where([['product_id',$product->id],['active',1]])->count();
        $stars = Review::starRating(Review::avgRating($product->id));
        return view('products.show', compact('product', 'data','viewproductinfo','productImages','stars','reviewCount','productSizes'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
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
        $this->validate($request, [
          'name' => 'required|max:50|min:3',
          'primary_category' => 'required|max:20|min:3',
          'secondary_category' => 'required|max:20|min:3',
          'price' => 'required|numeric|between:0,9999.99',
          'stock' => 'required|numeric|between:0,9999',
          'low_stock_level' => 'required|numeric|between:0,9999',
          'location' => 'required',
          'description' => 'required|max:5000|min:20',
          'sale_percentage' => 'required|numeric|between:0,100',
      ]);
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->primary_category = $request->primary_category;
        $product->secondary_category = $request->secondary_category;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->low_stock_level = $request->low_stock_level;
        $product->location = $request->location;
        $product->description = $request->description;
        $product->sale_percentage = $request->sale_percentage;
        $product->weight = $request->weight;
        $product->langth = $request->langth;
        $product->width = $request->width;
        $product->height = $request->height;
        $product->update();
          return redirect('/products/'.$product->id.'/edit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
    }
}
