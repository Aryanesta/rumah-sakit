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
use App\Http\Controllers\Surgicare\DashboardController as SurgicareDashboardController;
use App\Http\Controllers\Surgicare\PatientAccountMonitoringController;
use App\Http\Controllers\Surgicare\PatientListController as SurgicarePatientListController;
use App\Http\Controllers\Surgicare\PostOpChecklistController as SurgicarePostOpChecklistController;
use App\Http\Controllers\Surgicare\PreOpChecklistController as SurgicarePreOpChecklistController;
use App\Http\Controllers\Surgicare\SiapOperasi\SaveGuideChecklistController;
use App\Http\Controllers\Surgicare\SiapOperasi\SebelumOperasiController;
use App\Http\Controllers\Surgicare\SiapOperasi\SetelahOperasiController;
use App\Http\Controllers\Surgicare\SiapOperasi\SiapCheckController;
use App\Http\Controllers\Surgicare\SiapOperasi\SiapOperasiDashboardController;
use App\Http\Controllers\Surgicare\SiapOperasi\SubmitSiapCheckController;
use App\Http\Controllers\Surgicare\SiapOperasi\UntukKeluargaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [AppLauncherController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/apps/surgicon/{any?}', function (?string $any = null) {
    $suffix = $any !== null && $any !== '' ? '/'.$any : '';

    return redirect('/apps/surgicare'.$suffix, 301);
})->where('any', '.*');

Route::middleware(['auth', 'verified'])->prefix('apps')->name('apps.')->group(function () {
    Route::prefix('surgicare')->name('surgicare.')->group(function () {
        Route::middleware('role:patient')->prefix('siap-operasi')->name('siap-operasi.')->group(function () {
            Route::get('/', SiapOperasiDashboardController::class)->name('index');
            Route::get('/sebelum-operasi', SebelumOperasiController::class)->name('sebelum');
            Route::get('/setelah-operasi', SetelahOperasiController::class)->name('setelah');
            Route::get('/keluarga', UntukKeluargaController::class)->name('keluarga');
            Route::get('/siap-check', SiapCheckController::class)->name('siap-check');
            Route::post('/checklist', SaveGuideChecklistController::class)->name('checklist.store');
            Route::post('/siap-check', SubmitSiapCheckController::class)->name('siap-check.store');
        });

        Route::middleware('role:nurse,doctor,superadmin,admin')->group(function () {
            Route::get('/', SurgicareDashboardController::class)->name('index');
            Route::get('/patients', SurgicarePatientListController::class)->name('patients.index');
            Route::get('/monitoring', PatientAccountMonitoringController::class)->name('monitoring.index');
            Route::get('/patients/{patient}/pre-op-checklist', SurgicarePreOpChecklistController::class)
                ->where('patient', '[A-Za-z0-9-]+')
                ->name('patients.pre-op-checklist');
            Route::get('/patients/{patient}/post-op-checklist', SurgicarePostOpChecklistController::class)
                ->where('patient', '[A-Za-z0-9-]+')
                ->name('patients.post-op-checklist');
        });
    });
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
