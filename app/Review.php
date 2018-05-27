<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Review extends Model
{
  use SoftDeletes;
  protected $fillable = ['title', 'rating', 'body',];
  protected $table = 'reviews';
  protected $dates = ['deleted_at'];

  public static function StarRating($rating){
    //<img src='emptystar.png'>
    if($rating == 0){
      return '<br>';
    }
    $emptystars = 5 - $rating;
    $starRating = '';
    for ($x = 1; $x <= $rating; $x++) {
      $starRating = $starRating. "<img src='/fullstar.png' width='15px'>";
    }
     for ($x = 1; $x <= $emptystars; $x++) {
       $starRating = $starRating. "<img src='/emptystar.png' width='15px'>";
    }

      return $starRating;
    }
    public static function avgRating($product_id){
    $reviews = DB::table('reviews')->where([['product_id',$product_id],['active',1]])->get();
    if(!empty($reviews[0])){
      $x = 0;
      $total = 0;
      foreach ($reviews as $review) {
        $total = $total + $review->rating;
        $x++;
      }
      $avg = $total / $x;
      return round($avg);
      }

    }

}
