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
            $table->string('client_number');
            $table->string('name');
            $table->string('last_name');
            $table->string('second_last_name');
            $table->string('rfc');
            $table->string('birthday');
            $table->string('gender');
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
        Schema::dropIfExists('chubb_beneficiaries');
    }
}
