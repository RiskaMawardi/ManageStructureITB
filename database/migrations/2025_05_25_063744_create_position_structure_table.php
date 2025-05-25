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
        Schema::create('Position_Structure_IBT', function (Blueprint $table) {
            $table->bigIncrements('PositionRecord');
            $table->string('PositionID')->nullable();
            $table->string('EmployeePosition')->nullable();
            $table->string('CompanyID')->nullable();
            $table->string('AreaID')->nullable();
            $table->string('AreaBaseID')->nullable();
            $table->string('AreaFF')->nullable();
            $table->string('RayonID')->nullable();
            $table->string('LineID')->nullable();
            $table->string('LineBaseID')->nullable();
            $table->string('LinePositionFF')->nullable();
            $table->string('AmPos')->nullable();
            $table->string('RmPos')->nullable();
            $table->string('SMPos')->nullable();
            $table->string('NSMPos')->nullable();
            $table->string('MMPos')->nullable();
            $table->string('GMPos')->nullable();
            $table->string('MDPos')->nullable();
            $table->string('Station')->nullable();
            $table->dateTime('StartDate')->nullable();
            $table->dateTime('EndDate')->nullable();
            $table->string('PositionStatus')->nullable();
            $table->string('UserID')->nullable();
            $table->dateTime('LastUpdate')->nullable();
            $table->string('AreaGroupID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Position_Structure_IBT');
    }
};
