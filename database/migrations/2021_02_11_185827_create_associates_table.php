<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssociatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->string('client_number');
            $table->string('name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('second_last_name',255)->nullable();
            $table->string('role',100)->nullable();
            $table->boolean('active_association')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('associates');
    }
}
