<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;


class Address extends Model
{
  protected $fillable = ['firstline', 'secondline', 'city','county','postcode', 'tel1', 'tel2'];
  protected $table = 'address';
  protected $dates = ['deleted_at'];

  public function setFirstlineAttribute($value){
    $this->attributes['firstline'] = ucwords($value);
    }
  public function setSecondlineAttribute($value){
    $this->attributes['secondline'] = ucwords($value);
  }
  public function setCityAttribute($value){
    $this->attributes['city'] = ucwords($value);
  }
  public function setCountyAttribute($value){
    $this->attributes['county'] = ucwords($value);
  }
  public function setPostcodeAttribute($value){
    $this->attributes['postcode'] = strtoupper($value);
  }

  public static function addressVerification($address_id){
    $address = DB::table('address')->where('id', $address_id)->get();
    if(isset($address[0])){
      if(Auth::id() == $address[0]->user_id){
        return 1;
      }
      else
      {
        return 0;
      }
    }
    else{
      return 0;
    }
  }
}
