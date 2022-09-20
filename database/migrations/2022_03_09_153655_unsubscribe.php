<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Unsubscribe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unsubscribe_form', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('message');
            $table->timestamps();
            $table->foreign('email')->references('email')->on('customers_sessions');

        });
    }

    /**
     * Reverse the migrations        .
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unsubscribe_form');
    }
}
