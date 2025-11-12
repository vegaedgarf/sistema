<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MemberActivityController;
use App\Http\Controllers\FinancialReportController;




// 1. Rutas Públicas
Route::get('/', function () {
    return view('home');
})->name('home');


// 2. Rutas Protegidas por Autenticación (Middleware: 'auth')
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Perfil de usuario (Cualquier usuario autenticado)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔐 2.1. ADMINISTRACIÓN DEL SISTEMA (Solo 'admin')
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
        // Route::resource('reports', ReportController::class)->only(['index']);
    });

    // 🏆 2.2. MÓDULOS DEL EQUIPO (Roles: admin, profesor, entrenador, recepcionista)
    // El middleware 'auth' ya está activo en el grupo superior.
    Route::middleware(['role:admin|profesor|entrenador|recepcionista'])->group(function () {
        
        // MÓDULO DE MIEMBROS
        Route::resource('members', MemberController::class);

        // Rutas anidadas de contactos (Resource parcial)
        Route::prefix('members/{member}')->group(function () {
            // 👇 Rutas de CONTACTOS
            Route::get('contacts/create', [ContactController::class, 'create'])->name('contacts.create');
            Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');
            Route::get('contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
            Route::put('contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
            Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

            // 👇 Rutas de FICHA MÉDICA (Health Records)
            // Aquí utilicé Route::resource anidado para simplificar, pero si quieres control absoluto, mantenemos el Route::get/post/etc.
            Route::get('health-record', [HealthRecordController::class, 'show'])->name('health_records.show');
            Route::get('health-record/create', [HealthRecordController::class, 'create'])->name('health_records.create');
            Route::post('health-record', [HealthRecordController::class, 'store'])->name('health_records.store');
            Route::get('health-record/{healthRecord}/edit', [HealthRecordController::class, 'edit'])->name('health_records.edit');
            Route::put('health-record/{healthRecord}', [HealthRecordController::class, 'update'])->name('health_records.update');
            Route::delete('health-record/{healthRecord}', [HealthRecordController::class, 'destroy'])->name('health_records.destroy');
        });
        
        // MÓDULO DE MEMBRESÍAS Y PAGOS
        Route::resource('memberships', MembershipController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('member-activity', MemberActivityController::class);
        
       Route::get('member-activity/data', [MemberActivityController::class, 'data'])->name('member_activity.data');


        // MÓDULO DE REPORTES
        Route::get('financial-reports', [FinancialReportController::class, 'index'])->name('financial-reports.index');
    });

        Route::resource('financial_reports', FinancialReportController::class)->except(['destroy']);
        Route::delete('financial_reports/{id}', [FinancialReportController::class, 'destroy'])->name('financial_reports.destroy');
        Route::get('financial_reports/generate/{year}/{month}', [FinancialReportController::class, 'generateMonthlyReport'])->name('financial_reports.generate');


        Route::get('financial_reports/export/pdf/{year}/{month}', [FinancialReportController::class, 'exportPDF'])->name('financial_reports.export.pdf');
        Route::get('financial_reports/export/excel/{year}/{month}', [FinancialReportController::class, 'exportExcel'])->name('financial_reports.export.excel');




    // Ruta de prueba
    Route::get('/test-role', function () {
        return 'Middleware funcionando correctamente';
    })->middleware('role:admin');
});


// Rutas de autenticación generadas por Breeze/Jetstream
require __DIR__.'/auth.php';