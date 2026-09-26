<?php

use App\Http\Controllers\Angsmart\CarePlanController as AngsmartCarePlanController;
use App\Http\Controllers\Angsmart\DashboardController as AngsmartDashboardController;
use App\Http\Controllers\Angsmart\HandoverController as AngsmartHandoverController;
use App\Http\Controllers\Angsmart\NursingCareController as AngsmartNursingCareController;
use App\Http\Controllers\Angsmart\PatientListController as AngsmartPatientListController;
use App\Http\Controllers\Angsmart\ReportController as AngsmartReportController;
use App\Http\Controllers\Angsmart\StorePatientController as AngsmartStorePatientController;
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
    Route::prefix('angsmart')->name('angsmart.')->group(function () {
        Route::get('/', AngsmartDashboardController::class)->name('index');
        Route::get('/patients', AngsmartPatientListController::class)->name('patients.index');
        Route::post('/patients', AngsmartStorePatientController::class)->name('patients.store');
        Route::get('/patients/{patient}/nursing-care', AngsmartNursingCareController::class)
            ->where('patient', '[A-Za-z0-9-]+')
            ->name('patients.nursing-care');
        Route::get('/patients/{patient}/care-plan', AngsmartCarePlanController::class)
            ->where('patient', '[A-Za-z0-9-]+')
            ->name('patients.care-plan');
        Route::get('/handover', AngsmartHandoverController::class)->name('handover.index');
        Route::get('/reports', AngsmartReportController::class)->name('reports.index');
    });
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
