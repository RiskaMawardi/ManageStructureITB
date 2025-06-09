<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeListController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\ManageStructureController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/employee', [EmployeeListController::class, 'index'])->name('employee.index');
    Route::get('/employee/data', [EmployeeListController::class, 'fetchDataEmployee'])->name('employee.data');
    Route::post('/employee-store', [EmployeeListController::class, 'store'])->name('employee.store');
    Route::get('/employee/{id}/edit', [EmployeeListController::class, 'edit']);
    Route::put('/employee/update/{id}', [EmployeeListController::class, 'update'])->name('employee.update');
    Route::get('/employee-list', [EmployeeListController::class, 'getEmployeeList']);

    Route::get('/structure', [StructureController::class, 'index']);
    Route::post('/fetch-data', [StructureController::class, 'fetchDataByArea'])->name('structure.fetchData');
    Route::get('/structure/{id}', [StructureController::class, 'show']);    
    Route::get('/position-id/{posID}', [StructureController::class, 'getEmpIdByPositionId']);


    Route::get('/manage', [ManageStructureController::class, 'index']);
    Route::get('/check-position-id', [ManageStructureController::class, 'checkPositionId']);
    Route::post('/add-new-rayon',[ManageStructureController::class,'addNewRayon'])->name('addNewRayon');

    Route::get('/rayon/generate-pdf', [StructureController::class, 'generatePdf'])->name('rayon.generatePdf');
    Route::post('/position-map/set-vacant', [StructureController::class, 'setVacant']);
    Route::post('/position-map/update-emp', [StructureController::class, 'updateMap']);

   


});

require __DIR__.'/auth.php';
