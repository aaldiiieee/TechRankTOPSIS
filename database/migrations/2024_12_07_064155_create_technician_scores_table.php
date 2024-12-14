<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicianScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technician_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tech_id');
            $table->float('score')->comment('TOPSIS calculated score');
            $table->integer('rank')->comment('Rank of the technician');
            $table->timestamps();

            $table->foreign('tech_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technician_scores');
    }
}
