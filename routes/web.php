<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Views
Route::get('/', function () {
    return view('home');
})->name('home');

// Pages
Route::group(['as' => 'pages.'], function () {
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
    
    Route::get('/about/celiac-disease', [PageController::class, 'celiac'])->name('celiac');
    Route::get('/about/gluten-free-tips', [PageController::class, 'tips'])->name('tips');
    Route::get('/about/specialist-advice', [PageController::class, 'advice'])->name('advice');
});

// Auth Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout (Auth only)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// App Resources
Route::resource('products', ProductController::class);
Route::resource('locations', LocationController::class);
Route::resource('recipes', RecipeController::class);

// Favorites & User Resources
Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    Route::get('/my-recipes', [RecipeController::class, 'myRecipes'])->name('recipes.my');

    // Challenges
    Route::get('/daily-challenge', [\App\Http\Controllers\ChallengeController::class, 'getDailyChallenge'])->name('challenge.daily');
});

// Moved outside middleware to handle unauthenticated AJAX cleanly
Route::post('/favorites/toggle', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');

// Comments
Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');

// Language Switch
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'ar', 'en', 'es'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Recipe Approval & Management
    Route::get('/recipes', [\App\Http\Controllers\AdminController::class, 'recipesIndex'])->name('admin.recipes.index');
    Route::get('/recipes/{recipe}/edit', [\App\Http\Controllers\AdminController::class, 'recipeEdit'])->name('admin.recipes.edit');
    Route::patch('/recipes/{recipe}', [\App\Http\Controllers\AdminController::class, 'recipeUpdate'])->name('admin.recipes.update');
    Route::delete('/recipes/{recipe}', [\App\Http\Controllers\AdminController::class, 'recipeDestroy'])->name('admin.recipes.destroy');
    Route::patch('/recipes/{recipe}/approve', [\App\Http\Controllers\AdminController::class, 'approveRecipe'])->name('admin.recipes.approve');
    Route::patch('/recipes/{recipe}/refuse', [\App\Http\Controllers\AdminController::class, 'refuseRecipe'])->name('admin.recipes.refuse');
    
    // Location Approval
    Route::patch('/locations/{location}/approve', [\App\Http\Controllers\AdminController::class, 'approveLocation'])->name('admin.locations.approve');
    Route::patch('/locations/{location}/refuse', [\App\Http\Controllers\AdminController::class, 'refuseLocation'])->name('admin.locations.refuse');

    // Product Management
    Route::get('/products', [\App\Http\Controllers\AdminController::class, 'productsIndex'])->name('admin.products.index');
    Route::get('/products/create', [\App\Http\Controllers\AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::post('/products', [\App\Http\Controllers\AdminController::class, 'productStore'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [\App\Http\Controllers\AdminController::class, 'productEdit'])->name('admin.products.edit');
    Route::put('/products/{product}', [\App\Http\Controllers\AdminController::class, 'productUpdate'])->name('admin.products.update');
    Route::delete('/products/{product}', [\App\Http\Controllers\AdminController::class, 'productDestroy'])->name('admin.products.destroy');

    // Users Management
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'usersIndex'])->name('admin.users.index');
    Route::get('/users/{user}', [\App\Http\Controllers\AdminController::class, 'usersShow'])->name('admin.users.show');
    Route::patch('/users/{user}/toggle-block', [\App\Http\Controllers\AdminController::class, 'toggleBlockUser'])->name('admin.users.toggle-block');
});
});
