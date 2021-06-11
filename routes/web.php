<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
/*
 * Front-End section Routes
 *  
 */
Route::get('/',[\App\Http\Controllers\Website\WebsiteController::class, 'home'])->name('home');
Route::get('about-us',[\App\Http\Controllers\Website\WebsiteController::class, 'about'])->name('about-us');
Route::get('contact-us',[\App\Http\Controllers\Website\WebsiteController::class, 'contact'])->name('contact-us');

Route::group(['prefix' => 'products'], function(){
    Route::get('list',[\App\Http\Controllers\Website\ProductController::class, 'getList'])->name('products.list');
    Route::get('detail/{slug}',[\App\Http\Controllers\Website\ProductController::class, 'getDetail'])->name('products.detail');
});

Route::group(['middleware' => 'customer.guest:customer'], function(){
    Route::get('customer-register', [\App\Http\Controllers\Website\AuthenticationController::class, 'showRegistrationForm'])->name('customer.register');
    Route::post('customer-register', [\App\Http\Controllers\Website\AuthenticationController::class, 'register'])->name('customer.register');
    Route::get('customer-login', [\App\Http\Controllers\Website\AuthenticationController::class, 'showLoginForm'])->name('customer.login');
    Route::post('customer-login',[\App\Http\Controllers\Website\AuthenticationController::class, 'login'])->name('customer.auth');
    
    /*
    * Customer password links
    * 
    */
    Route::group(['prefix' => 'customer/password'], function(){
        Route::get('reset', [\App\Http\Controllers\Website\CustomerForgotPasswordController::class, 'showLinkRequestForm'])->name('customer_password.request');
        Route::post('email',[\App\Http\Controllers\Website\CustomerForgotPasswordController::class, 'sendResetLinkEmail'])->name('customer_password.email');
        Route::get('reset/{token}',[\App\Http\Controllers\Website\CustomerResetPasswordController::class, 'showResetForm'])->name('customer_password.reset');
        Route::post('reset',[\App\Http\Controllers\Website\CustomerResetPasswordController::class, 'reset'])->name('customer_password.update');
        
        Route::get('confirm',[\App\Http\Controllers\Website\CustomerConfirmPasswordController::class, 'showConfirmForm'])->name('customer_password.confirm');
        Route::post('confirm',[\App\Http\Controllers\Website\CustomerConfirmPasswordController::class, 'confirm'])->name('customer_password.confirm');
    });
});

Route::group(['middleware' => 'customer.auth'], function(){
    Route::post('customer-logout',[\App\Http\Controllers\Website\AuthenticationController::class, 'logout'])->name('customer.logout');
    Route::get('customer-dashboard',[\App\Http\Controllers\Website\WebsiteController::class, 'home'])->name('customer.dashboard');
    Route::get('my-orders',[\App\Http\Controllers\Website\CustomerDashboardController::class, 'previousOrder'])->name('customer.orders');
    Route::get('cart', [\App\Http\Controllers\Website\AddtocartController::class, 'addToCart'])->name('addtocart');
    Route::get('add-to-cart/{product}', [\App\Http\Controllers\Website\AddtocartController::class, 'cart'])->name('cart.add');
    Route::get('remove-from-cart/{id}', [\App\Http\Controllers\Website\AddtocartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('customer-invoice/{orderid}', [App\Http\Controllers\PdfController::class, 'generatePdf'])->name('customer.invoice');
    
    Route::post('check-out', [\App\Http\Controllers\Website\PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('pay', [\App\Http\Controllers\Website\PaymentController::class, 'pay'])->name('pay');
    
    Route::get('/email/verify', function () {
        return view('website.verify');
    })->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/');
    })->middleware(['signed'])->name('verification.verify');
    
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

/*
 *
 * Admin routes sections
 *  
 */

Route::prefix('admin')->group(function(){
    
    Auth::routes(['register' => false, 'verify' => false]);
    Route::middleware('auth')->group(function(){
        Route::get('dashboard',[App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // all product related routes
        Route::prefix('product')->group(function(){
            Route::get('list',[App\Http\Controllers\Admin\ProductController::class, 'productList'])->name('product.list');
            Route::get('add-edit/{id?}',[App\Http\Controllers\Admin\ProductController::class, 'getProductById'])->name('product.add-edit');
            Route::post('save',[App\Http\Controllers\Admin\ProductController::class, 'upsertProduct'])->name('product.upsert');
            Route::get('delete/{id}',[App\Http\Controllers\Admin\ProductController::class, 'deleteProduct'])->name('product.delete');
            Route::get('categories',[App\Http\Controllers\Admin\ProductController::class, 'productCategories'])->name('product.categories');
            Route::get('category/view/{id?}',[App\Http\Controllers\Admin\ProductController::class, 'getProductCategoryById'])->name('product.category');
            Route::post('category/save',[App\Http\Controllers\Admin\ProductController::class, 'upsertProductCategory'])->name('product.category.upsert');
        });
        Route::prefix('order')->group(function(){
            Route::get('list',[App\Http\Controllers\Admin\OrderController::class, 'orderList'])->name('order.list');
            Route::get('gst/report',[App\Http\Controllers\Admin\OrderController::class, 'gstReport'])->name('order.report');
            Route::get('detail/{id?}',[App\Http\Controllers\Admin\OrderController::class, 'getOrderById'])->name('order.details');
            Route::post('save/{order}',[App\Http\Controllers\Admin\OrderController::class, 'updateOrder'])->name('order.update');
            Route::get('generate-pdf/{orderid}', [App\Http\Controllers\PdfController::class, 'generatePdf'])->name('admin.download.pdf');
            
            Route::get('status/list',[App\Http\Controllers\Admin\OrderController::class, 'orderStatusList'])->name('order.statuslist');
            Route::get('tax/setting',[App\Http\Controllers\Admin\OrderController::class, 'taxSettingView'])->name('order.tax-setting');
        });
        
        Route::prefix('user')->group(function(){
            Route::get('customer/list',[App\Http\Controllers\Admin\UserController::class, 'customerList'])->name('customer.list');
            Route::get('admin/list',[App\Http\Controllers\Admin\UserController::class, 'adminUserList'])->name('admin.user-list');
        });
    });
});



