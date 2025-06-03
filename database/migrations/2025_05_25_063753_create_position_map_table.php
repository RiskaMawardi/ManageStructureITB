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
        Schema::create('Position_Map_IBT', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('PositionID');
            $table->string('EmpID');
            $table->string('EmployeePosition')->nullable();
            $table->string('Status_Default')->nullable();
            $table->string('Acting')->nullable();
            $table->string('IsVacant')->nullable();
            $table->string('IsCoordinator')->nullable();
            $table->string('Active')->nullable();
            $table->dateTime('StartDate')->nullable();
            $table->dateTime('EndDate')->nullable();
            $table->string('UserID')->nullable();
            $table->dateTime('LastUpdate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Position_Map_IBT');
    }
};
