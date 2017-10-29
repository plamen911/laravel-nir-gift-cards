<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('gift_cards');

        Schema::create('gift_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 10, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('sendto', ['me', 'someone'])->nullable();
            $table->integer('shipping_id')->unsigned()->default(0);
            // $table->foreign('shipping_id')->references('id')->on('shipping_methods');
            $table->integer('delivery_id')->unsigned()->default(1);
            $table->string('name')->nullable();
            $table->string('cctype')->nullable();
            $table->string('ccnumber')->nullable();
            $table->string('ccholder')->nullable();
            $table->string('ccexp_month')->nullable();
            $table->string('ccexp_year')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('status')->nullable();
            $table->string('reference')->nullable();
            $table->string('message')->nullable();
            $table->string('code')->nullable();
            $table->string('cvv_result')->nullable();
            $table->string('avs_result')->nullable();
            $table->string('risk_code')->nullable();
            $table->string('network_id')->nullable();
            $table->string('is_purchase_card')->nullable();
            $table->string('order_number')->nullable();
            $table->text('pool_numbers')->nullable();
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
        Schema::dropIfExists('gift_cards');
    }
}
