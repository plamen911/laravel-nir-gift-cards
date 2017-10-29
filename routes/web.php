<?php

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

use App\Models\Address;
use App\Models\GiftCard;
use Illuminate\Support\Facades\Mail;

Route::get('test_email', 'EmailController@send');

Route::get('/', 'GiftCardController@create');
Route::get('buy-gift-cards', 'GiftCardController@create');
Route::post('buy-gift-cards', 'GiftCardController@store');
Route::get('buy-gift-cards/{giftCard}', 'GiftCardController@edit')->where('giftCard', '[0-9]+');
Route::post('buy-gift-cards/{giftCard}', 'GiftCardController@update')->where('giftCard', '[0-9]+');

Route::get('buy-gift-cards/{giftCard}/address/{index}', 'AddressController@edit')->where('giftCard', '[0-9]+')->where('index', '[0-9]+');
Route::post('buy-gift-cards/{giftCard}/address/{index}', 'AddressController@update')->where('giftCard', '[0-9]+')->where('index', '[0-9]+');

Route::get('buy-gift-cards/{giftCard}/purchase', 'PurchaseController@edit')->where('giftCard', '[0-9]+');
Route::post('buy-gift-cards/{giftCard}/purchase', 'PurchaseController@update')->where('giftCard', '[0-9]+');
Route::get('buy-gift-cards/{giftCard}/purchase-success', 'PurchaseController@purchaseSuccess')->where('giftCard', '[0-9]+');

// Admin Panel Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    Route::get('orders', 'Admin\OrderController@index')->name('admin.orders');
    Route::get('orders/{giftCard}', 'Admin\OrderController@show')->where('giftCard', '[0-9]+')->name('admin.order.details');
    Route::get('payment-gateway', 'Admin\PaymentGatewayController@edit')->name('admin.payment-gateway');
    Route::post('payment-gateway', 'Admin\PaymentGatewayController@update');
    Route::get('profile', 'Admin\ProfileController@edit')->name('admin.profile');
    Route::post('profile', 'Admin\ProfileController@update');
});

Auth::routes();

// Disable user registration
Route::match(['get', 'post'], 'register', function () {
    return redirect()->route('login');
});
