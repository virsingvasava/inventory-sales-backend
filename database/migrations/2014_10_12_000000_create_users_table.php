<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('date_of_joining')->nullable();
            $table->string('profile_img')->nullable();
            $table->string('user_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('logged_in_kiosk_id')->nullable();
            $table->integer('role')->nullable();
            $table->integer('status')->default(0);   
            $table->integer('login_logout_status')->default(0);  
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
