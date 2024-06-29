<?php

use App\DataTables\UsersDataTable;
use App\Events\UserRegistered;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Jobs\SendMail;
use App\Models\User;

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
    return view('welcome');
});

Route::get('/dashboard', function (UsersDataTable $dataTable) {
    /* $users = User::paginate(10);
    return view('dashboard', compact('users'));*/
    return $dataTable->render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
Route::get('/posts/trash',[PostController::class,'trashed'])->name('posts.trashed');
Route::get('/posts/{id}/restore',[PostController::class,'restore'])->name('posts.restore');
Route::delete('/posts/{id}/force-delete',[PostController::class,'forceDelete'])->name('posts.force_delete');


    Route::get('/send-email', function () {
        SendMail::dispatch();
    });


Route::resource('posts',PostController::class);
});
Route::get('/user-register', function () {
    event(new UserRegistered());
    dd("success");
});
require __DIR__ . '/auth.php';
