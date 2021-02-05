<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectorCustomInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collector_custom_inputs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('custom_input_id');
            $table->unsignedBigInteger('collector_id');
            $table->string('vlaidate')->nullable()->comment('validaciones del formulario');

            $table->foreign('custom_input_id')
                ->references('id')
                ->on('custom_inputs');

            $table->foreign('collector_id')
                ->references('id')
                ->on('collectors');
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
        Schema::dropIfExists('collector_custom_inputs');
    }
}
