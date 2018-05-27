<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('products', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->decimal('price',5,2);
          $table->string('stock');
          $table->string('location');
          $table->string('description');
          $table->string('image');
          $table->integer('weight');
          $table->integer('langth');
          $table->integer('width');
          $table->integer('height');
          $table->SoftDeletes();
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
