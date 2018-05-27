<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersProducts extends Model
{
  use SoftDeletes;
  //protected $fillable = ['name', 'price', 'stock','location','description', 'image', 'weight','langth','width','height'];
  protected $table = 'orders_products';
  protected $dates = ['deleted_at'];
}
