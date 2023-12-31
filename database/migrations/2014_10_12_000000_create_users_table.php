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
            $table->bigIncrements('id');
            $table->string('serial_number')->nullable();
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->string('designation', 100)->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('national_number', 100)->nullable();
            $table->integer('gender')->nullable();
            $table->integer('age')->namespace;
            $table->string('qualification', 100)->nullable();
            $table->string('blood_group', 100)->nullable();
            $table->date('dob')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('owner_id')->nullable();
            $table->string('owner_type', 100)->nullable();
            $table->boolean('status')->nullable();
            $table->string('language', 100)->default('en');
            $table->string('card_brand', 100);
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
};
