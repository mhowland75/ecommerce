<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Product extends Model
{
      use SoftDeletes;
      protected $fillable = ['name', 'price', 'stock','location','description', 'image', 'weight','langth','width','height'];
      protected $table = 'products';
      protected $dates = ['deleted_at'];

      public function basket(){
        return $this->hasMany(Basket::class,'product_id');
      }
      public function setNameAttribute($value){
        $this->attributes['name'] = ucwords($value);
        }
      public function setPrimaryCategoryAttribute($value){
        $this->attributes['primary_category'] = ucwords($value);
      }
      public function setsecondaryCategoryAttribute($value){
        $this->attributes['secondary_category'] = ucwords($value);
      }

      public static function navBar(){

        $categorys = DB::table('products')->select('primary_category')->where('active',1)->get();
        $primarycategoryArray = array();
        $secondarycategoryArray = array();
        $navbarArray = array();
        //listing primary category

        foreach ($categorys as $category) {
          if (!in_array($category->primary_category, $primarycategoryArray))
              {
                $primarycategoryArray[] = $category->primary_category;
              }
            }
            foreach($primarycategoryArray as $primary_category){
              $secondary_categorys = DB::table('products')->select('secondary_category')->where([['primary_category', $primary_category],['active',1]])->get();
                $secondarycategoryArray = array();
              foreach($secondary_categorys as $secondary_category){

                if(!in_array($secondary_category->secondary_category, $secondarycategoryArray))
                    {
                      $secondarycategoryArray[] = $secondary_category->secondary_category;

                    }

            }
            $navbarArray[$primary_category] = $secondarycategoryArray;
          }
        return $navbarArray;
      }

}
