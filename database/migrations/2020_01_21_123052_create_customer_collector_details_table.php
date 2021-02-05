<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCollectorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_collector_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_collector_id');
            $table->unsignedBigInteger('custom_input_id');
            $table->text('value')->nullable();
            $table->timestamps();

           $table->foreign('customer_collector_id')->references('id')->on('customer_collectors');
           $table->foreign('custom_input_id')->references('id')->on('custom_inputs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_collector_details');
    }
}
