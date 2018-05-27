<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Auth;
use DB;
use Session;
class ReviewsController extends Controller
{
      public function backendReviewsSearch(request $request){

          $search = $request->search;
         $searchBy = $request->searchBy;
         if ($searchBy == 'name'){
           $users = DB::table('users')->where($request->searchBy, 'Like', '%'.$request->search.'%')->paginate(50);
           $reviews = array();
           foreach($users as $user){
             $reviews[] = DB::table('reviews')->where('user_id',$user->id)->get();
           }
           //return $reviews;
           $data = array();
           foreach($reviews as $review){
             if(!empty($review[0])){
               $x = array();
               $productData = DB::table('products')->where('id', $review['0']->product_id)->get();
               $userData = DB::table('users')->where('id', $review['0']->user_id)->get();
               $x['user'] = $userData;
               $x['review'] = $review;
               $x['product'] = $productData;
               $data[] = $x;
             }
           }
         }
         if ($searchBy == 'product'){
           $products = DB::table('products')->where('name', 'Like', '%'.$request->search.'%')->paginate(50);
           $reviews = array();
           foreach($products as $product){
             $reviews[] = DB::table('reviews')->where('product_id',$product->id)->get();
           }
           //return $reviews;
           $data = array();
           foreach($reviews as $review){
             if(!empty($review[0])){
               $x = array();
               $productData = DB::table('products')->where('id', $review['0']->product_id)->get();
               $userData = DB::table('users')->where('id', $review['0']->user_id)->get();
               $x['user'] = $userData;
               $x['review'] = $review;
               $x['product'] = $productData;
               $data[] = $x;
             }
           }
         }
         if($searchBy == 'active'){
             $reviews =  DB::table('reviews')->where('active',1)->get();
             $data = array();
             foreach($reviews as $review){

                 $x = array();
                 $productData = DB::table('products')->where('id', $review->product_id)->get();
                 $userData = DB::table('users')->where('id', $review->user_id)->get();
                 $x['user'] = $userData;
                 $x['review'][0] = $review;
                 $x['product'] = $productData;
                 $data[] = $x;

             }
         }
         if($searchBy == 'deactivated'){
             $reviews =  DB::table('reviews')->where('active',0)->get();
             $data = array();
             foreach($reviews as $review){

                 $x = array();
                 $productData = DB::table('products')->where('id', $review->product_id)->get();
                 $userData = DB::table('users')->where('id', $review->user_id)->get();
                 $x['user'] = $userData;
                 $x['review'][0] = $review;
                 $x['product'] = $productData;
                 $data[] = $x;

             }
         }

         //return $data;
         return view('reviews.index', compact('data','search','searchBy'));
      }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function activateReview($id){
       $status = DB::table('reviews')->where('id',$id)->get();
       if($status[0]->active == 1){
         DB::table('reviews')
               ->where('id', $id)
               ->update(['active' => 0, ]);
       }
       elseif($status[0]->active == 0){
         DB::table('reviews')
               ->where('id', $id)
               ->update(['active' => 1, ]);
       }
        return redirect()->back();
     }

     public function index(request $request){

         $searchError = 0;
         if(!empty($request->search)){
           $search = $request->search;
               $reviews=array();
               $x = DB::table('reviews')->where('title', 'Like', '%'.$request->search.'%')->get();
               foreach($x as $y){
                 $reviews[] = $y;
               }
              $users = DB::table('users')->where('name', 'Like', '%'.$request->search.'%')->get();
               foreach($users as $user){
                 $x = DB::table('reviews')->where('user_id',$user->id)->get();
                 if(!empty($x[0]->id)){
                   //loop though x
                   foreach($x as $y){
                     //if reviews is empty skip entery check
                     if(!empty($reviews[0]->id)){
                       foreach($reviews as $review){
                         //loop though reviewsif review id is found in the db call
                           if($review->id == $y->id){
                             break;
                           }
                           else{
                             $reviews[] = $y;
                             break;
                           }
                       }
                     }
                     else{
                       $reviews[] = $y;
                     }
                   }
                 }
               }

               $products = DB::table('products')->where('name', 'Like', '%'.$request->search.'%')->get();
                foreach($products as $product){
                  $x = DB::table('reviews')->where('product_id',$product->id)->get();
                  if(!empty($x[0]->id)){
                    //loop though x
                    foreach($x as $y){
                      //if reviews is empty skip entery check
                      if(!empty($reviews[0]->id)){
                        foreach($reviews as $review){
                          //loop though reviewsif review id is found in the db call
                            if($review->id == $y->id){
                              break;
                            }
                            else{
                              $reviews[] = $y;
                              break;
                            }
                        }
                      }
                      else{
                        $reviews[] = $y;
                      }
                    }
                  }
                }
               //if x is empty skip array addition
               foreach($reviews as $review){
                 $x = array();
                 $productData = DB::table('products')->where('id', $review->product_id)->get();
                 $userData = DB::table('users')->where('id', $review->user_id)->get();
                 $review->rating = Review::starRating($review->rating);
                 $x['user'] = $userData;
                 $x['review'][0] = $review;
                 $x['product'] = $productData;
                 $data[] = $x;
               }
       }
       else{
         $search = '';
        $reviews = DB::table('reviews')->get();
        foreach($reviews as $review){
          $x = array();
          $productData = DB::table('products')->where('id', $review->product_id)->get();
          $userData = DB::table('users')->where('id', $review->user_id)->get();
          $review->rating = Review::starRating($review->rating);
          $x['user'] = $userData;
          $x['review'][0] = $review;
          $x['product'] = $productData;
          $data[] = $x;
        }
       }
       //return $data;
       return view('reviews.index', compact('data','search'));
   }

  /*  public function index()
    {
      $search = '';
       $searchBy = 'name';
        if(!empty($_GET['sort'])){
          if($_GET['sort'] == 'all'){
            $reviews =  DB::table('reviews')->get();

          }
          elseif($_GET['sort'] == 'on'){
            $reviews =  DB::table('reviews')->where('active',1)->get();
          }
          elseif($_GET['sort'] == 'off'){
            $reviews =  DB::table('reviews')->where('active',0)->get();
          }
        }
        else{
          $reviews =  DB::table('reviews')->get();
        }
        $data = array();
        foreach($reviews as $review){
          $x = array();
          $productData = DB::table('products')->where('id', $review->product_id)->get();
          $userData = DB::table('users')->where('id', $review->user_id)->get();
          $review->rating = Review::starRating($review->rating);
          $x['user'] = $userData;
          $x['review'][0] = $review;
          $x['product'] = $productData;
          $data[] = $x;
        }
        //return $data;
        return view('reviews.index', compact('data','search','searchBy'));
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
      $product = DB::table('products')->where('id',$id)->get();
      return view('reviews.create', compact('id','product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'title' => 'required|max:40|min:3',
        'body' => 'required|max:5000|min:3',
        'rating' => 'required|numeric|between:0,5',
      ]);
      $reviews = DB::table('reviews')->where([['user_id',Auth::id()],['product_id',$request->product_id]])->get();
      if(empty($reviews[0])){
        $review = new Review;
        $review->user_id = Auth::id();
        $review->product_id = $request->product_id;
        $review->title = $request->title;
        $review->rating = $request->rating;
        $review->body = $request->body;
        $review->active = 0;
        $review->save();
       return redirect('products/'.$request->product_id);
     }else{
       return \Redirect::back()->withWarning( 'You have already reviewed this product' );
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
