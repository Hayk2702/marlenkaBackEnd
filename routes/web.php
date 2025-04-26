<?php

use App\Http\Controllers\AboutUsDataController;
use App\Http\Controllers\AwardsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HomeHighlightiesController;
use App\Http\Controllers\HomeIngredientController;
use App\Http\Controllers\HomeRomanticController;
use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\HomeVideoController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect('/dashboard' );
});


Route::group(['prefix' => 'dashboard', 'middleware' => ['authWeb','isAdmin']], function () {

    Route::resource('/', DashboardController::class)->names('dashboard');

    Route::get('abort403', [DashboardController::class, 'abort403'])->name('abort403');

    Route::resource('contact_us', ContactUsController::class)->names('contact_us');

    Route::resource('home_slider', HomeSliderController::class)->names('home_slider');

    Route::post('sliderPosition', [HomeSliderController::class, 'sliderPosition'])->name('sliderPosition');

    Route::get('getProducts', [DashboardController::class, 'getProducts'])->name('getProducts');

    Route::resource('home_highlighties', HomeHighlightiesController::class)->names('home_highlighties');

    Route::resource('home_video', HomeVideoController::class)->names('home_video');

    Route::resource('home_romantic', HomeRomanticController::class)->names('home_romantic');

    Route::resource('home_ingredient', HomeIngredientController::class)->names('home_ingredient');

    Route::resource('products', ProductController::class)->names('products');

    Route::get('getCategories', [DashboardController::class, 'getCategories'])->name('getCategories');

    Route::get('getFlavors', [DashboardController::class, 'getFlavors'])->name('getFlavors');

    Route::resource('orders', OrderController::class)->names('orders');

    Route::post('finishOrder', [OrderController::class, 'finishOrder'])->name('finishOrder');

    Route::resource('about_us_data', AboutUsDataController::class)->names('about_us_data');

    Route::post('setMainAbout', [AboutUsDataController::class, 'setMainAbout'])->name('setMainAbout');

    Route::resource('awards', AwardsController::class)->names('awards');

    Route::resource('newses', NewsController::class)->names('newses');

    Route::resource('faqs', FAQController::class)->names('faqs');

    Route::resource('privacy_policy', PrivacyPolicyController::class)->names('privacy_policy');

    Route::resource('terms', TermsController::class)->names('terms');

    Route::resource('categories', CategoriesController::class)->names('categories');


});


Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
