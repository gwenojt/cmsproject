<?php

use App\Http\Controllers\FaqController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuickLinksController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect()->route('login'); 
});

Route::get('/login', function () {
    return Inertia::render('Login'); // Assuming 'Login' is the name of your Login Vue component
})->name('login');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/faqs', function () {
    return Inertia::render('Faqs');
})->middleware(['auth', 'verified'])->name('faqs');


Route::get('/genericpages', function () {
    return Inertia::render('GenericPages');
})->middleware(['auth', 'verified'])->name('genericpages');

Route::get('/article', function () {
    return Inertia::render('Article');
})->middleware(['auth', 'verified'])->name('article');

Route::get('/quickLink', function () {
    return Inertia::render('QuickLink');
})->middleware(['auth', 'verified'])->name('quickLink');

Route::get('/image', function () {
    return Inertia::render('Gallery');
})->middleware(['auth', 'verified'])->name('image');

Route::get('/faqlist',[FaqController::class, 'table']);

Route::post('/delete-faqs',[FaqController::class, 'deleteFaqs']);

Route::post('/submit-form',[FaqController::class, 'saveFaq']);

Route::get('/faqs-data/{id?}',[FaqController::class, 'editForm']);

Route::post('/submit-edit-form',[FaqController::class, 'editFormSave']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//for generic pages
Route::get('/genericlist',[GenericController::class, 'table']);
Route::post('/delete-content',[GenericController::class, 'deleteContent']);
Route::get('/content-data/{id?}',[GenericController::class, 'editForm']);
Route::post('/submit-page',[GenericController::class, 'savePage']);
Route::get('/get-parent/{id?}',[GenericController::class, 'getParent']);


Route::middleware(['auth', 'verified'])->group(function () {

Route::post('/images', [ImageController::class, 'index']);

// Route::post('/images', [ImageController::class, 'store']);
Route::post('/uploadimage', [ImageController::class, 'saveDoc']);
});


//for manage account
// account route
Route::get('/manageacc', function () {
    return Inertia::render('ManageAcc');
})->middleware(['auth', 'verified'])->name('manageacc');
Route::get('/userlist',[UserController::class, 'table']);
Route::post('/submit-user',[UserController::class, 'saveAccount']);
Route::get('/user-data/{id?}',[UserController::class, 'editForm']);
Route::post('/submit-edit-form',[UserController::class, 'editFormSave']);
Route::get('/get-user-status/{id}', [UserController::class, 'getUserStatus']);
Route::post('/deactivate-acc/{id}', [UserController::class, 'deactivateAcc']);
Route::post('/activate-acc/{id}', [UserController::class, 'activateAcc']);
Route::get('/check-user-exists/{email}', [UserController::class, 'checkUserExists']);
Route::get('/changepassword', function () {
    return Inertia::render('ChangePassword');
})->middleware(['auth', 'verified'])->name('changepassword');
Route::get('/get-user-access/{id}', [UserController::class, 'getUserAccess']);
Route::post('/submit-user-access', [UserController::class, 'editUserAccess']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard}', [UserController::class, 'dashboard']);
});

//for quicklinks
Route::post('/submit-current',[QuickLinksController::class, 'saveCurAware']);
Route::get('/get-parent/{section}/{linkCategory?}', [QuickLinksController::class, 'getParent']);
// Route::get('/get-parent/{id?}',[QuickLinksController::class, 'getParent']);
Route::get('/quicklinklist',[QuickLinksController::class, 'table']);
Route::post('/delete-content', [QuickLinksController::class, 'deleteContent']);

require __DIR__.'/auth.php';
