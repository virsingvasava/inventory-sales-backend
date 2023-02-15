<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKioskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kiosk', function (Blueprint $table) {
            $table->id();
            $table->string('kiosk_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('kiosk_name')->nullable();
            $table->string('outlet_location_id')->nullable();
            $table->integer('status')->default(0); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kiosk');
    }
}
