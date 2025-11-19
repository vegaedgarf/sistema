<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    RoleController,
    PermissionController,
    UserController,
    MemberController,
    ContactController,
    HealthRecordController,
    MembershipController,
    PaymentController,
    MemberActivityController,
    FinancialReportController,
    MembershipPriceController,
    ActivityController,
    PlanController,
    FamilyGroupController,
    TestController
};
use App\Models\Member;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::view('/', 'home')->name('home');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::view('/dashboard', 'dashboard')
        ->middleware('verified')
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Perfil de usuario
    |--------------------------------------------------------------------------
    */
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Administración del sistema (solo admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {
        Route::resources([
            'roles' => RoleController::class,
            'permissions' => PermissionController::class,
            'users' => UserController::class,
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Módulos principales (admin, profesor, entrenador, recepcionista)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin|profesor|entrenador|recepcionista'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Miembros
        |--------------------------------------------------------------------------
        */
        Route::resource('members', MemberController::class);

        /*
        |--------------------------------------------------------------------------
        | Contactos & Fichas médicas anidadas
        |--------------------------------------------------------------------------
        */
        Route::prefix('members/{member}')->group(function () {

            // Contactos
            Route::controller(ContactController::class)->group(function () {
                Route::get('contacts/create', 'create')->name('contacts.create');
                Route::post('contacts', 'store')->name('contacts.store');
                Route::get('contacts/{contact}/edit', 'edit')->name('contacts.edit');
                Route::put('contacts/{contact}', 'update')->name('contacts.update');
                Route::delete('contacts/{contact}', 'destroy')->name('contacts.destroy');
            });

            // Fichas médicas
            Route::controller(HealthRecordController::class)->group(function () {
                Route::get('health-record', 'show')->name('health_records.show');
                Route::get('health-record/create', 'create')->name('health_records.create');
                Route::post('health-record', 'store')->name('health_records.store');
                Route::get('health-record/{healthRecord}/edit', 'edit')->name('health_records.edit');
                Route::put('health-record/{healthRecord}', 'update')->name('health_records.update');
                Route::delete('health-record/{healthRecord}', 'destroy')->name('health_records.destroy');
            });
        });

        /*
        |--------------------------------------------------------------------------
        | Membresías & Pagos
        |--------------------------------------------------------------------------
        */
      
       Route::post('memberships/calculate-price', [MembershipController::class, 'calculatePrice'])
    ->name('memberships.calculate_price');

        Route::resource('memberships', MembershipController::class);
        Route::resource('payments', PaymentController::class);

        /*
        |--------------------------------------------------------------------------
        | Actividades de miembros
        |--------------------------------------------------------------------------
        */
        Route::get('member-activity/data', [MemberActivityController::class, 'data'])
            ->name('member_activity.data');

// === INICIO: RUTAS AJAX AGREGADAS ===
        Route::get('member-activity/search-members', [MemberActivityController::class, 'searchMembers'])
            ->name('member_activity.search_members');

        Route::get('member-activity/prices-by-activities', [MemberActivityController::class, 'getPricesByActivities'])
            ->name('member_activity.prices_by_activities');
        // === FIN: RUTAS AJAX AGREGADAS ===





        Route::resource('member-activity', MemberActivityController::class)
            ->names('member_activity');

        /*
        |--------------------------------------------------------------------------
        | Actividades
        |--------------------------------------------------------------------------
        */
        Route::resource('activities', ActivityController::class);

        /*
        |--------------------------------------------------------------------------
        | Precios de membresía (historial + ABM)
        |--------------------------------------------------------------------------
        */
        Route::get('membership-prices/history', [MembershipPriceController::class, 'history'])
            ->name('membership_prices.history');

        Route::resource('membership-prices', MembershipPriceController::class)
            ->names('membership_prices');

     
      




        /*
        |--------------------------------------------------------------------------
        | Reportes financieros
        |--------------------------------------------------------------------------
        */
        Route::resource('financial-reports', FinancialReportController::class)
            ->only(['index'])
            ->names('financial_reports');

        Route::controller(FinancialReportController::class)->group(function () {
            Route::get('financial-reports/generate/{year}/{month}', 'generateMonthlyReport')
                ->name('financial_reports.generate');

            Route::get('financial-reports/export/pdf/{year}/{month}', 'exportPDF')
                ->name('financial_reports.export.pdf');

            Route::get('financial-reports/export/excel/{year}/{month}', 'exportExcel')
                ->name('financial_reports.export.excel');
        });

        
        Route::resource('plans', PlanController::class);
        // CRUD para Grupos Familiares y sus miembros
        Route::post('family-groups/{familyGroup}/add-member', [FamilyGroupController::class, 'addMember'])
    ->name('family_groups.add_member');
        Route::resource('family-groups', FamilyGroupController::class);

    });

    /*
    |--------------------------------------------------------------------------
    | Test / Debug
    |--------------------------------------------------------------------------
    */
    Route::controller(TestController::class)->group(function () {
        Route::get('/test', 'index')->name('test.index');
        Route::get('/test/data', 'data')->name('test.data');
    });

 




    /*
    |--------------------------------------------------------------------------
    | Debug en entorno local
    |--------------------------------------------------------------------------
    */
    if (app()->environment('local')) {

        Route::get('/debug-route', fn() => response()->json([
            'ok' => true,
            'app_url' => config('app.url'),
            'time' => now()->toDateTimeString(),
        ]));

        Route::view('/test-members', 'test.test_members');

        Route::get('/test-members/data', fn() =>
            datatables()->of(
                Member::select(['id', 'first_name', 'last_name', 'email'])
            )->make(true)
        );
    }
});

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';









/* rutas funcional al 10-11

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    RoleController,
    PermissionController,
    UserController,
    MemberController,
    ContactController,
    HealthRecordController,
    MembershipController,
    PaymentController,
    MemberActivityController,
    FinancialReportController
};
use App\Http\Controllers\MembershipPriceController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ActivityController;

use App\Models\Member;
use Yajra\DataTables\Facades\DataTables;
*/
/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------

Route::get('/', fn() => view('home'))->name('home');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas por Autenticación
|--------------------------------------------------------------------------

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('dashboard'))
        ->middleware('verified')
        ->name('dashboard');

    // Perfil de usuario
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMINISTRACIÓN DEL SISTEMA (Solo 'admin')
    |--------------------------------------------------------------------------
    
    Route::middleware(['role:admin'])->group(function () {
        Route::resources([
            'roles' => RoleController::class,
            'permissions' => PermissionController::class,
            'users' => UserController::class,
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | MÓDULOS PRINCIPALES (admin, profesor, entrenador, recepcionista)
    |--------------------------------------------------------------------------
    
    Route::group([], function () {

        // 👤 Miembros
        Route::resource('members', MemberController::class);

        // 📇 Contactos y Fichas Médicas anidadas en miembros
        Route::prefix('members/{member}')->group(function () {
            // Contactos
            Route::controller(ContactController::class)->group(function () {
                Route::get('contacts/create', 'create')->name('contacts.create');
                Route::post('contacts', 'store')->name('contacts.store');
                Route::get('contacts/{contact}/edit', 'edit')->name('contacts.edit');
                Route::put('contacts/{contact}', 'update')->name('contacts.update');
                Route::delete('contacts/{contact}', 'destroy')->name('contacts.destroy');
            });

            // Fichas médicas
            Route::controller(HealthRecordController::class)->group(function () {
                Route::get('health-record', 'show')->name('health_records.show');
                Route::get('health-record/create', 'create')->name('health_records.create');
                Route::post('health-record', 'store')->name('health_records.store');
                Route::get('health-record/{healthRecord}/edit', 'edit')->name('health_records.edit');
                Route::put('health-record/{healthRecord}', 'update')->name('health_records.update');
                Route::delete('health-record/{healthRecord}', 'destroy')->name('health_records.destroy');
            });
        });

        // 💳 Membresías y Pagos
        Route::resource('memberships', MembershipController::class);
        Route::resource('payments', PaymentController::class);

            // Ruta para DataTables (requiere estar autenticado)
        Route::get('member-activity/data', [MemberActivityController::class, 'data'])
            ->name('member_activity.data');

// 🏋️ Actividades de miembros
        Route::resource('member-activity', MemberActivityController::class)
            ->names('member_activity');

      

        // 📊 Reportes financieros
        Route::resource('financial-reports', FinancialReportController::class)
            ->only(['index'])
            ->names('financial_reports');

        Route::controller(FinancialReportController::class)->group(function () {
            Route::get('financial-reports/generate/{year}/{month}', 'generateMonthlyReport')
                ->name('financial_reports.generate');
            Route::get('financial-reports/export/pdf/{year}/{month}', 'exportPDF')
                ->name('financial_reports.export.pdf');
            Route::get('financial-reports/export/excel/{year}/{month}', 'exportExcel')
                ->name('financial_reports.export.excel');
        });

        
      // Nueva ruta para el histórico
    Route::get('membership_prices/history', [MembershipPriceController::class, 'history'])->name('membership_prices.history');


          Route::resource('membership_prices', MembershipPriceController::class)
    ->middleware(['auth', 'role:admin|profesor|entrenador|recepcionista']);


   Route::group(['middleware' => ['role:admin|profesor|entrenador|recepcionista']], function () { Route::resource('activities', ActivityController::class); });

    // Rutas de Precios de Membresía
    //Route::resource('membership_prices', MembershipPriceController::class);

  


    });





Route::get('/test', [TestController::class, 'index'])->name('test.index');
Route::get('/test/data', [TestController::class, 'data'])->name('test.data');

  
    /*
    |--------------------------------------------------------------------------
    | RUTAS DE DEPURACIÓN / PRUEBAS (solo entorno local)
    |--------------------------------------------------------------------------
    
    if (app()->environment('local')) {
        Route::get('/debug-route', fn() => response()->json([
            'ok' => true,
            'app_url' => config('app.url'),
            'time' => now()->toDateTimeString(),
        ]));

        Route::get('/test-members', fn() => view('test.test_members'));
        Route::get('/test-members/data', fn() =>
            datatables()->of(Member::select(['id', 'first_name', 'last_name', 'email']))->make(true)
        );
    }
});

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------

require __DIR__ . '/auth.php';

*/

/*
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

use App\Models\Member;

use Yajra\DataTables\Facades\DataTables;

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
    });

    // 🏆 2.2. MÓDULOS DEL EQUIPO (Roles: admin, profesor, entrenador, recepcionista)
    //Route::middleware(['role:admin|profesor|entrenador|recepcionista'])->group(function () {
    Route::group([], function () { 
        // MÓDULO DE MIEMBROS
        Route::resource('members', MemberController::class);

        // Rutas anidadas de contactos y ficha médica
        Route::prefix('members/{member}')->group(function () {
            // 👇 Rutas de CONTACTOS
            Route::get('contacts/create', [ContactController::class, 'create'])->name('contacts.create');
            Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');
            Route::get('contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
            Route::put('contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
            Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

            // 👇 Rutas de FICHA MÉDICA (Health Records)
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
        
        
        // 🔥 MÓDULO DE ASISTENCIAS/ACTIVIDAD DE MIEMBROS
        // Se define el index y la ruta personalizada de forma explícita.
  //      Route::get('member-activity', [MemberActivityController::class, 'index'])->name('member_activity.index');
//        Route::get('member-activity/data', [MemberActivityController::class, 'data'])->name('member_activity.data');

        // 🔥 MÓDULO DE ASISTENCIAS / ACTIVIDAD DE MIEMBROS
        Route::resource('member-activity', MemberActivityController::class)
            ->names('member_activity');

        // Ruta adicional para DataTables
        //Route::get('member-activity/data', [MemberActivityController::class, 'data'])
        //->name('member_activity.data');


        // 🔥 MÓDULO DE REPORTES FINANCIEROS
        // Se mantiene la versión limpia que ya había funcionado:
        //Route::resource('financial-reports', FinancialReportController::class); 
Route::resource('financial-reports', FinancialReportController::class)->only(['index'])->names('financial_reports');

        Route::get('financial-reports/generate/{year}/{month}', [FinancialReportController::class, 'generateMonthlyReport'])->name('financial_reports.generate');
        Route::get('financial-reports/export/pdf/{year}/{month}', [FinancialReportController::class, 'exportPDF'])->name('financial_reports.export.pdf');
        Route::get('financial-reports/export/excel/{year}/{month}', [FinancialReportController::class, 'exportExcel'])->name('financial_reports.export.excel');
        
    }); // <-- El grupo de roles cierra aquí.

//Route::get('member-activity/data', [App\Http\Controllers\MemberActivityController::class, 'data'])
 //   ->name('member_activity.data');


Route::get('/debug-route', function () {
    return response()->json([
        'ok' => true,
        'app_url' => config('app.url'),
        'time' => now()->toDateTimeString()
    ]);
});
    // Ruta de prueba
//    Route::get('/test-role', function () {
  //      return 'Middleware funcionando correctamente';
   // })->middleware('role:admin');


    //Route::get('member-activity', [MemberActivityController::class, 'index'])->name('member_activity.index');
    //Route::get('member-activity/data', [MemberActivityController::class, 'data'])->name('member_activity.data');



//Route::get('test/members', [App\Http\Controllers\TestController::class, 'members'])->name('test.members');
//Route::get('test/members/data', [App\Http\Controllers\TestController::class, 'membersData'])->name('test.members.data');
//Route::get('/test-members', function () {
 //   return response()->json(Member::select(['id', 'first_name', 'last_name', 'email'])->get());
//});


Route::get('/test-members', function () {
    return view('test.test_members');
});

Route::get('/test-members/data', function () {
    return datatables()->of(Member::select(['id', 'first_name', 'last_name', 'email']))->make(true);
});

Route::get('member-activity/data', [MemberActivityController::class, 'data'])
    ->name('member_activity.data')
    ->withoutMiddleware(['auth']);

});


// Rutas de autenticación generadas por Breeze/Jetstream
require __DIR__.'/auth.php';*/