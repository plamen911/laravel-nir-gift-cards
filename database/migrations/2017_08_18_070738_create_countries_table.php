<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('countries');

        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_name',5)->unique();
            $table->string('long_name',100)->nullable();
            $table->string('iso3',10)->nullable();
            $table->string('num_code',10)->nullable();
            $table->string('phone_code',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('countries');
    }
}
