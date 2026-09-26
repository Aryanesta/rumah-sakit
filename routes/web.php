<?php

use App\Http\Controllers\Ansafe\DashboardController as AnsafeDashboardController;
use App\Http\Controllers\Ansafe\EducationController as AnsafeEducationController;
use App\Http\Controllers\Ansafe\FamilyMonitoringController as AnsafeFamilyMonitoringController;
use App\Http\Controllers\Ansafe\PatientAssessmentController as AnsafePatientAssessmentController;
use App\Http\Controllers\Ansafe\PatientListController as AnsafePatientListController;
use App\Http\Controllers\AppLauncherController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [AppLauncherController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('apps')->name('apps.')->group(function () {
    Route::view('/surgicon', 'apps.coming-soon', ['moduleName' => 'Surgicon'])->name('surgicon.index');
    Route::view('/angsmart', 'apps.coming-soon', ['moduleName' => 'Angsmart'])->name('angsmart.index');
    Route::prefix('ansafe')->name('ansafe.')->group(function () {
        Route::get('/', AnsafeDashboardController::class)->name('index');
        Route::get('/patients', AnsafePatientListController::class)->name('patients.index');
        Route::get('/patients/{patient}/assessment', AnsafePatientAssessmentController::class)
            ->where('patient', '[A-Za-z0-9-]+')
            ->name('patients.assessment');
        Route::get('/education', AnsafeEducationController::class)->name('education.index');
        Route::get('/patients/{patient}/family-monitoring', AnsafeFamilyMonitoringController::class)
            ->where('patient', '[A-Za-z0-9-]+')
            ->name('patients.family-monitoring');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
