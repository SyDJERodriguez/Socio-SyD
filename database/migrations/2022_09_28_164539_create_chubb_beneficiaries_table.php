<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChubbBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chubb_beneficiaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_number')->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('second_last_name')->nullable();
            $table->string('rfc')->nullable();
            $table->string('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('report_id')->nullable();
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
        Schema::dropIfExists('chubb_beneficiaries');
    }
}
