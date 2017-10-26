<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentGatewayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payment_gateway');

        Schema::create('payment_gateway', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',25)->nullable();
            $table->string('value')->nullable();
            $table->string('site',25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payment_gateway');
    }
}
