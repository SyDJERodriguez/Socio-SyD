<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelasistBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telasist_beneficiaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_number');
            $table->string('name');
            $table->string('last_name');
            $table->string('second_last_name');
            $table->string('email');
            $table->string('birthday');
            $table->string('phone');
            $table->string('gender');
            $table->string('benefit');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('report_id');
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
        Schema::dropIfExists('telasist_beneficiaries');
    }
}
