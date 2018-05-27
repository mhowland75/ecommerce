<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
  protected $table = 'delivery';
  public $timestamps = false;

  public function setNameAttribute($value){
    $this->attributes['name'] = ucwords($value);
  }
  public function setEtaAttribute($value){
    $this->attributes['eta'] = ucwords($value);
  }
  public function setNotesAttribute($value){
    $this->attributes['notes'] = ucfirst($value);
  }
}
