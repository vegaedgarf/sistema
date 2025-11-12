<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HealthRecordController;
//use App\Http\Controllers\RoutineController;
//use App\Http\Controllers\PaymentController;
//use App\Http\Controllers\ReportController;

// Página pública principal
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return view('home');
})->name('home');

// Dashboard (solo usuarios autenticados)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔐 Administración del sistema (solo admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
       // Route::resource('reports', ReportController::class)->only(['index']);
    });

    // 👥 Módulo de miembros
//    Route::middleware(['role:admin|profesor|entrenador|recepcionista'])->group(function () {
  //      Route::resource('members', MemberController::class);
   // });

 


// 👥 Módulo de miembros
Route::middleware(['role:admin|profesor|entrenador|recepcionista'])->group(function () {
    Route::resource('members', MemberController::class);

    // 👇 Rutas ANIDADAS de contactos (dentro de cada miembro)
    Route::get('members/{member}/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('members/{member}/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('members/{member}/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('members/{member}/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('members/{member}/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});


// modulo registro medicos
Route::middleware(['auth', 'role:admin|entrenador|profesor|recepcionista'])->group(function () {
    // Rutas anidadas dentro de members
    Route::get('members/{member}/health-record', [HealthRecordController::class, 'show'])->name('healthRecords.show');
    Route::get('members/{member}/health-record/create', [HealthRecordController::class, 'create'])->name('healthRecords.create');
    Route::post('members/{member}/health-record', [HealthRecordController::class, 'store'])->name('healthRecords.store');
    Route::get('members/{member}/health-record/{healthRecord}/edit', [HealthRecordController::class, 'edit'])->name('healthRecords.edit');
    Route::put('members/{member}/health-record/{healthRecord}', [HealthRecordController::class, 'update'])->name('healthRecords.update');
    Route::delete('members/{member}/health-record/{healthRecord}', [HealthRecordController::class, 'destroy'])->name('healthRecords.destroy');
});


//Modulo memberships

Route::middleware(['auth', 'role:admin|entrenador|profesor|recepcionista'])->group(function () {
    Route::resource('memberships', MembershipController::class);
    Route::resource('payments', PaymentController::class);
});



// modulo contacto
//    Route::middleware(['auth', 'role:admin'])->group(function () {
 //   Route::resource('contacts', ContactController::class);
  //      });


/*
Route::resource('members', MemberController::class);
Route::resource('contacts', ContactController::class);

*/



    // 🏋️ Rutinas
   // Route::middleware(['role:admin|profesor|entrenador'])->group(function () {
 //       Route::resource('routines', RoutineController::class);
//    });

    // 💰 Pagos
  //  Route::middleware(['role:admin|recepcionista'])->group(function () {
   //     Route::resource('payments', PaymentController::class);
  //  });

});
Route::get('/test-role', function () {
    return 'Middleware funcionando correctamente';
})->middleware(['auth', 'role:admin']);


require __DIR__.'/auth.php';
