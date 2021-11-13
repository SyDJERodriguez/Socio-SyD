<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('associate_id')->unsigned()->nullable();
            $table->string('name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('second_last_name',255)->nullable();
            $table->string('mobile_number',25)->nullable();
            $table->string('percent',25)->nullable();
            $table->string('relationship',100)->nullable();
            $table->boolean('is_subbeneficiaries')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customer_platforms');
            //$table->foreign('associate_id')->references('id')->on('associates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiaries');
    }
}
