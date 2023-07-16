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
        Schema::create('board_history_and_rochets', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('doctor_id')->constrained('doctors','id')->onDelete('cascade');
            // $table->unsignedBigInteger('patient_id')->constrained('patients','id')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->string('link');
            $table->string('type');
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
        Schema::dropIfExists('board_history_and_rochets');
    }
};
