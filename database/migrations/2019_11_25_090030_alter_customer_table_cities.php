<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCustomerTableCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table){
            $table->dropColumn('state');
            $table->dropColumn('city');

            $table->bigInteger('state_id')->unsigned()->nullable();
            $table->bigInteger('city_id')->unsigned()->nullable();

            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('city_id')->references('id')->on('cities');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table){
            $table->dropColumn('state_id');
            $table->dropColumn('city_id');
        });

    }
}
