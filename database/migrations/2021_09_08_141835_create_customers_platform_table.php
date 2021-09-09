<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersPlatformTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_platforms', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
		    $table->string('client_number')->nullable()->default(null);
		    $table->string('name')->length(150)->nullable()->default(null);
		    $table->string('last_name')->length(150)->nullable()->default(null);
		    $table->string('second_last_name')->length(150)->nullable()->default(null);
		    $table->string('email')->length(100)->nullable()->default(null);
		    $table->string('mobile_number')->length(25)->nullable()->default(null);
		    $table->timestamp('created_at')->nullable();
		    $table->timestamp('updated_at')->nullable();
		    $table->bigInteger('branch_id')->nullable()->default(null);
		    $table->integer('is_new')->default(0);
		    $table->string('email_validate')->nullable();
		    $table->integer('phone_validate')->length(11)->nullable()->default(null);
		    $table->string('gender')->length(10)->nullable()->default(null);
		    $table->string('phone')->length(15)->nullable()->default(null);
		    $table->date('birthday')->nullable()->default(null);
		    $table->string('client_type')->length(50)->nullable()->default(null);
		    $table->string('street')->nullable()->default(null);
		    $table->string('colonia')->nullable()->default(null);
		    $table->string('postal_code')->nullable()->default(null);
		    $table->integer('education')->length(11)->nullable()->default(null);
		    $table->bigInteger('state_id')->length(20)->nullable()->default(null);
		    $table->bigInteger('city_id')->length(20)->nullable()->default(null);
		    $table->string('source')->nullable()->default(null);
		    $table->integer('customer_level')->default(0);
		    $table->string('str_branch')->nullable()->default(null);
		    $table->bigInteger('collector_id')->length(20)->nullable()->default(null);
		    $table->string('company')->nullable()->default(null);
		    $table->string('work')->nullable()->default(null);
		    $table->string('job')->nullable()->default(null);
		    $table->string('interest')->nullable()->default(null);
		    $table->string('rfc')->nullable()->default(null);
		    $table->string('cnt')->length(11)->nullable()->default(null);
		    $table->string('RFC_Company')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_platforms');
    }
}
