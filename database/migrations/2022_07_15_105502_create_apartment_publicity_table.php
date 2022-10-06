<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentPublicityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_publicity', function (Blueprint $table) {
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->foreign('apartment_id')->references('id')->on('apartments')->cascadeOnDelete();
            $table->unsignedBigInteger('publicity_id')->nullable();
            $table->foreign('publicity_id')->references('id')->on('publicities')->cascadeOnDelete(); 
            $table->dateTime('publicity_start_date')->nullable();
            $table->dateTime('publicity_expiration_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_publicity');
    }
}
