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
            $table->string('PositionID')->nullable();
            $table->string('EmpID')->nullable();
            $table->string('EmployeePosition')->nullable();
            $table->boolean('Status_Default')->default(false);
            $table->boolean('Acting')->default(false);
            $table->boolean('IsVacant')->default(false);
            $table->boolean('IsCoordinator')->default(false);
            $table->boolean('Active')->default(false);
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
