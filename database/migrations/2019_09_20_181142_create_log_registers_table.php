<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_registers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_number')->nullable();
            $table->string('ip')->nullable();
            $table->string('device')->nullable();
            $table->text('form_data')->nullable();
            $table->integer('status')->nullable();
            $table->text('msg')->nullable();
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
        Schema::dropIfExists('log_registers');
    }
}
