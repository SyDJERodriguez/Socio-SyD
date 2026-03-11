<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_number',13);
            $table->string('tmat',13);
            $table->string('quantity',13);
            $table->string('amount',20);
            $table->string('sale_office',13);
            $table->date('transaction_date');
            $table->string('payment_method',13);
            $table->string('error_message');
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
        Schema::dropIfExists('transactions_log');
    }
}
