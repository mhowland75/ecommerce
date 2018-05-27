<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('address', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->string('firstline');
          $table->string('secondline');
          $table->string('city');
          $table->string('county');
          $table->string('postcode');
          $table->integer('tel1');
          $table->integer('tel2');
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
