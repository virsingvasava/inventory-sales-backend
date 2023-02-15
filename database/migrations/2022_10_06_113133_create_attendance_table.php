<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable(); 
            $table->string('kiosk_id')->nullable(); 
            $table->string('login_at')->nullable(); 
            $table->string('logout_at')->nullable(); 
            $table->string('pack_sold')->nullable(); 
            $table->string('transaction_order_count')->nullable();
            $table->string('total_sale')->nullable(); 
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
        Schema::dropIfExists('attendance');
    }
}
