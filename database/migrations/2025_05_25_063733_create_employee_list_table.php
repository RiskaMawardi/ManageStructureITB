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
        Schema::create('EmployeeList_IBT', function (Blueprint $table) {
            $table->bigIncrements('RefEmpID');
            $table->string('CompanyID')->nullable();
            $table->string('EmployeeID')->unique();
            $table->string('EmpOldID')->nullable();
            $table->string('EmployeeName')->nullable();
            $table->string('EmployeeStatus')->nullable();
            $table->dateTime('JoinDate')->nullable();
            $table->dateTime('EndDate')->nullable();
            $table->string('StatusVacant')->nullable();
            $table->string('EmailID')->nullable();
            $table->string('UserID')->nullable();
            $table->dateTime('LastUpdate')->nullable();
            $table->string('PhoneNumber')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('EmployeeList_IBT');
    }
};
