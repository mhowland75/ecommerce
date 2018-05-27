<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('product_sizes', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('product_id');
          $table->string('size');
          $table->decimal('price',5,2);
          $table->string('stock');
          $table->string('low_stock_level');
          $table->string('location');
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
