<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug');
            $table->string('thumb');
            $table->text('description');
            $table->float('rooms')->default(1)->between(1, 20)->unsigned();
            $table->float('beds')->default(1)->between(1, 20)->unsigned();
            $table->float('baths')->default(1)->between(1, 20)->unsigned();
            $table->smallInteger('sqm')->default(1)->between(1, 10000)->unsigned();
            $table->string('address');
            $table->decimal('lat', 8, 6);
            $table->decimal('lon', 9, 6);
            $table->boolean('visibility')->default(true);
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
        Schema::dropIfExists('apartments');
    }
}