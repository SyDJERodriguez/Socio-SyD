<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidatesCustomerBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validates_customer_branch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_number');
            $table->string('branch_id');
            $table->boolean('validate');
            $table->date('validate_date');
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
        Schema::dropIfExists('validates_customer_branch');
    }
}
