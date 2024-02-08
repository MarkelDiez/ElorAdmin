<?php

use App\Http\Controllers\CycleRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RoleController;


use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\RecoverPasswordController;

use App\Models\Role;
use App\Models\User;
use App\Models\Cycle;
use App\Models\Department;
use App\Models\Module;
use Illuminate\Pagination\LengthAwarePaginator;


Route::get('/admin', function () {
    // Verificar si el usuario está autenticado y tiene el rol de administrador
    if (auth()->check() && auth()->user()->hasRole('Administrador')) {
        // Permitir el acceso al panel de administración
        $totalUsers = User::count();
        $alumnos = User::obtenerUsuariosPorRol('estudiante')->count();
        $usuariosMatriculados = $alumnos - User::studentsNotInCycleRegister()->count();
        $totalCycles = Cycle::count();
        $usersSinRol = User::countUsersWithoutRole();
        $totalModules = Module::count();
        $totalDepartment=Department::count();

        return view('infoAdmin', compact('totalDepartment','totalUsers','usersSinRol','totalModules','totalCycles', 'usuariosMatriculados'));
    }

    // Si no tiene el rol de administrador, redirigir o mostrar un mensaje de acceso denegado
    return redirect('/')->with('error', 'Acceso denegado. Debes ser administrador.');
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    // Ruta para el panel de administración
    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        // Rutas para el panel de administración
        Route::resource('departments', DepartmentController::class);
        Route::resource('cycles', CycleController::class);
        Route::resource('modules', ModuleController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('cycleRegister', CycleRegisterController::class);
        // ... otras rutas de administrador
    });
});


//Route::resource('departments', DepartmentController::class);
//Route::resource('cycles', CycleController::class);
//Route::resource('modules', ModuleController::class);
//Route::resource('roles', RoleController::class);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

use Illuminate\Support\Facades\Auth;
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users', [UserController::class, 'index2']);

Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change.password.form');
Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('change.password');

Route::get('/recover-password', [RecoverPasswordController::class, 'showResetForm'])->name('recover.password.form');
Route::post('/recover-password', [RecoverPasswordController::class, 'reset'])->name('recover.password');

Route::get('/departments', [DepartmentController::class, 'index2']);

Route::get('/registerUser', [UserController::class, 'showRegistrationForm'])->name('registerUser');
Route::post('/admin/users/create', [UserController::class, 'create']);

Route::get('/cycles', [CycleController::class, 'index2']);

use App\Http\Controllers\LocaleController;

Route::get('/cambiar-idioma/{locale}', [LocaleController::class, 'cambiarIdioma'])->name('cambiar-idioma');







