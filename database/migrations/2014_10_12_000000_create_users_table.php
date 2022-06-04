<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->unsignedBigInteger('role_id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('avatar')->nullable();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('address')->nullable();
            $table->boolean('gender')->nullable();
            $table->string('job')->nullable();
            $table->string('mobile')->nullable();
            $table->date('birthday')->nullable();

            $table->rememberToken();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
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
};
