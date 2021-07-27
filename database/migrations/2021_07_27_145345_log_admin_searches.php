<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogAdminSearches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_admin_searches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user');
            $table->string('name');
            $table->string('wanted_client');
            $table->string('date');
            $table->string('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_admin_searches');
    }
}
