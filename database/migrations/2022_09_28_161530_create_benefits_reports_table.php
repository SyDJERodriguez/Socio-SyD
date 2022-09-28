<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenefitsReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefits_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('created_date');
            $table->string('status');
            $table->string('created_by');
            $table->string('approved_by');
            $table->string('approved_date');
            $table->string('report_id');
            $table->string('type_report');
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
        Schema::dropIfExists('benefits_reports');
    }
}
