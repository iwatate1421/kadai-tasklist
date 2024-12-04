<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController; // 追記
use App\Http\Controllers\TasksController; //追記

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
Route::get('/', [TasksController::class, 'index']);
Route::get('/dashboard', [TasksController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/tasks/{task}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TasksController::class, 'update'])->name('tasks.update');

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('users', UsersController::class, ['only' => ['index', 'show']]);
    Route::resource('tasks', TasksController::class);
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
