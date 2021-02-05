<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collectors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250);
            $table->string('title',250);
            $table->string('redirect_to', 250)->nullable();
            $table->text('style')->nullable();
            $table->text('head')->nullable();
            $table->text('body_code')->nullable();
            $table->text('footer_code')->nullable();
            $table->string('type')->nullable();
            $table->string('source')->nullable();
            $table->string('source_key')->nullable();

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
        Schema::dropIfExists('collectors');
    }
}
