<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_technician', function (Blueprint $table) {
            $table->uuid('report_id')->primary();
            $table->string('device');
            $table->string('brand');
            $table->string('kerusakan');
            $table->string('imageUrl');
            $table->string('imageDesc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_technician');
    }
};
