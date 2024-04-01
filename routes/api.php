<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AuthController, UserController, HomeController, CommonController, CouponController, FatoorahPaymentGatewayController, SubscriptionController,TagsController};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('test/{local}', [AuthController::class, 'getTest']);
Route::post('verify-otp/{local}', [AuthController::class, 'verifyOtp']);
Route::post('upload/image/{local}', [AuthController::class, 'uploadImage']);
Route::post('sign-up/{local}', [AuthController::class, 'signUp']);
Route::post('login/{local}', [AuthController::class, 'login']);
Route::match(['get', 'post'], 'forgot-password/{local}', [AuthController::class, 'forgotPassword']);
Route::post('otp-verify/{local}', [AuthController::class, 'otpVerify']);
Route::post('login-otp/{local}', [AuthController::class, 'loginOtp']);
Route::post('send-otp/{local}', [AuthController::class, 'sendOtp']);
Route::post('set-password/{local}', [AuthController::class, 'changePassword']);
Route::get('get-tag_base-search/{local}',[TagsController::class,'getTagBaseSearch']);
//setnew password api
Route::post('get-vendor-list/{local}', [HomeController::class, 'getVendorList']);
Route::group(['middleware' => 'auth:api'], function () {
	Route::post('logout/{local}', [AuthController::class, 'logout']);
	Route::post('update-profile/{local}', [UserController::class, 'updateProfile']);
	Route::post('get-vendor-coupon/{local}', [UserController::class, 'getCoupon']);
	Route::get('get-my-profile/{local}', [UserController::class, 'getMyProfile']);
	Route::post('save-vendor-ratings/{local}',[UserController::class,'addReview']);
	Route::get('get-vendor-ratings/{local}',[UserController::class,'getVendorReviews']);
	Route::get('delete-user-account/{local}',[UserController::class,'deleteAccount']);
	Route::post('update/favorite/{local}',[UserController::class,'updateFavorite']);
	Route::post('user/favorites/{local}',[UserController::class,'getFavoriteList']);

	Route::get('get-product-list/{local}', [HomeController::class, 'getProduct']);


	Route::get('check-subscription/{local}', [CouponController::class, 'checkSubscription']);
	Route::post('claim-coupon/{local}', [CouponController::class, 'applyCoupon']);
	Route::get('get-redeemed-coupon-list/{local}', [CouponController::class, 'getRedeemedCouponList']);
	Route::get('get-saved-wishlist/{local}', [CouponController::class, 'getWishlistCouponList']);
	Route::get('add-remove-from-wishlist/{local}', [CouponController::class, 'addToWishList']);
	Route::post('claim-coupon-pin-verification/{local}',[CouponController::class,'claimCouponPinVerification']);

	// Route::get('product-listing',UserController::class,'');
	Route::get('make-subscription-payment/{local}',[FatoorahPaymentGatewayController::class,'index']);
	Route::post('save-subscription-payment/{local}',[FatoorahPaymentGatewayController::class,'callBack']);
	Route::get('get-payment-history/{local}',[FatoorahPaymentGatewayController::class,'getPaymentHistory']);


});
Route::match(['get', 'post'], 'home/{local}', [HomeController::class, 'homeScreen']);
Route::get('get-vendor-list/{local}', [HomeController::class, 'getVendorList']);
Route::get('get-vendor-details/{local}', [UserController::class, 'getVendorDetail']);
Route::get('get-vendor-coupon/{local}', [UserController::class, 'getCoupon']);
Route::get('get-coupon-details/{local}', [UserController::class, 'getCouponDetail']);
Route::get('get-plans-list/{local}', [UserController::class, 'getPlansList']);
Route::get('get-sub-categories/{local}', [CommonController::class, 'getSubCategories']);
Route::get('get-faq/{local}/{cid?}', [CommonController::class, 'getFaq']);
Route::get('get-settings/{local}', [CommonController::class, 'getSettings']);
Route::get('get-contact-us/{local}', [CommonController::class, 'getContactUs']);


// Api for subscription.
Route::group(['middleware' => 'auth:api'], function () {
	Route::prefix('subscriptions')->group(function () {
		Route::get('/', [SubscriptionController::class, 'index']);
		// Route::post('create', [SubscriptionController::class, 'createSubscription']);
		// Route::post('product/create', [SubscriptionController::class, 'createProduct']);
		// Route::post('purchase', [SubscriptionController::class, 'subscriptionsPurchase']);
		Route::post('stripeIntent', [SubscriptionController::class, 'stripeEndpoint']);
	});
});

// SuccWebhook on stripe
Route::any('payment_intent/succeeded/stripe', [SubscriptionController::class, 'stripeIntentSucceededResponse']);
Route::any('payment_intent/payment_failed/stripe', [SubscriptionController::class, 'stripeIntentFailedResponse']);
Route::any('charge/succeeded/stripe', [SubscriptionController::class, 'stripeChargeSucceededResponse']);
Route::any('charge/payment_failed/stripe', [SubscriptionController::class, 'stripechargeFailedResponse']);

Route::prefix('subscriptions/myfatoorah')->group(function () {
	Route::get('/', [FatoorahPaymentGatewayController::class, 'index']);
	Route::get('callback', [FatoorahPaymentGatewayController::class, 'callbackurl'])->name('myfatoorah.callback');
});
