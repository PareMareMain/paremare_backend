<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{AdminController,UserController,VenderController,TelrController,CategoryController,OfferController,PlatformCouponController,BannerController,SubAdminController,SubscriptionController,TagsController, PromoCodeController};
use App\Http\Controllers\Api\FatoorahPaymentGatewayController;
use App\Http\Controllers\Api\SubscriptionController as SubscriptionApiController;
use App\Http\Controllers\Vendor\{LoginController,CouponController,ProductController,BannerVendorController,MyFatoorahController, ProfileController};
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/admin', function () {
    return redirect('admin/login');
});
Route::get('/', function () {
    return redirect('vendor/login');
    // return redirect('admin/login');
});
Route::get('/privacy-policy',[AdminController::class,'privacyPol']);
Route::get('/apple-pay',[TelrController::class,'index']);
Route::prefix('admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::match(['get','post'],'login', 'login')->name('login');
        Route::match(['get', 'post'], 'check-email-exist', 'checkEmailExist')->name('check-email-exist');
    });
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('logout',[AdminController::class,'logout'])->name('logout');
        Route::get('dashoard',[AdminController::class,'dashoard'])->name('dashboard');
        Route::resource('user', UserController::class);
        Route::post('user/delete',[UserController::class,'deletedUser'])->name('user.deleted');
        Route::get('user/block/{id}',[UserController::class,'blockUser'])->name('user.blockUser');
        Route::post('user/update/profile',[UserController::class,'updateProfile'])->name('update.user.profile');
        Route::post('free/subscription', [SubscriptionApiController::class, 'stripeEndpoint'])->name('free.subscription');
        Route::resource('vendor', VenderController::class);
        Route::get('vendor/delete/{id}',[VenderController::class,'getDeleted'])->name('vendor.getDeleted');
        Route::get('vendor/delbanner/banner',[VenderController::class,'DelBanner'])->name('delVendorBanner');
        //Routes for category
        Route::get('tags-index',[TagsController::class,'index'])->name('tag.index');
        Route::get('tag-create',[TagsController::class,'create'])->name('tag.create');
        Route::post('tag-store',[TagsController::class,'store'])->name('tag.store');
        Route::get('tag-edit',[TagsController::class,'tagEdit'])->name('tag.edit');
        Route::post('tag-update',[TagsController::class,'update'])->name('tag.update');
        Route::get('tag-delete/{id}',[TagsController::class,'destroy'])->name('tag.delete');
        Route::get('category-index',[CategoryController::class,'categoryIndex'])->name('category.index');
        Route::get('category-create',[CategoryController::class,'categoryCreate'])->name('category.create');
        Route::post('category-store',[CategoryController::class,'categoryStore'])->name('category.store');
        Route::get('category-edit/{id}',[CategoryController::class,'categoryEdit'])->name('category.edit');
        Route::post('category-update/{id}',[CategoryController::class,'categoryUpdate'])->name('category.update');
        Route::get('category-delete/{id}',[CategoryController::class,'categoryDestroy'])->name('category.delete');
        Route::get('category-change-status/{id}/{status}',[CategoryController::class,'changeCategoryStatus'])->name('category.changestatus');
        //Routes for su-category
        Route::get('sub-category-index/{id}',[CategoryController::class,'subCategoryIndex'])->name('subcategory.index');
        Route::get('sub-category-create/{id}',[CategoryController::class,'subCategoryCreate'])->name('subcategory.create');
        Route::post('sub-category-store/{id}',[CategoryController::class,'subCategoryStore'])->name('subcategory.store');
        Route::get('sub-category-edit/{cat_id}/{id}',[CategoryController::class,'subCategoryEdit'])->name('subcategory.edit');
        Route::post('sub-category-update/{cat_id}/{id}',[CategoryController::class,'subCategoryUpdate'])->name('subcategory.update');
        Route::get('sub-category-delete/{id}',[CategoryController::class,'subCategoryDestroy'])->name('subcategory.delete');
        Route::get('sub-category-change-status/{id}/{status}',[CategoryController::class,'changeSubCategoryStatus'])->name('subcategory.changestatus');
        Route::resource('offer', OfferController::class);
        Route::resource('sub-admin', SubAdminController::class);
        Route::get('sub-admin/delete/{id}',[SubAdminController::class,'getDeleted'])->name('sub-admin.getDeleted');
        Route::match(['get','post'],'sub-admin/permissions/{id}',[SubAdminController::class,'getPermissionList'])->name('sub-admin.permissions');
        Route::get('get-coupon-requests',[PlatformCouponController::class,'getCouponRedeemedList'])->name('coupon.getCouponRedeemedList');
        Route::match(['get','post'],'get-coupon-request-details/{id}',[PlatformCouponController::class,'getCouponDetails'])->name('coupon.getCouponDetails');
        Route::match(['get','post'],'get-coupon-requested-details/{id}',[PlatformCouponController::class,'getCouponRequestDetails'])->name('coupon.getCouponRequestDetails');
        Route::resource('platform', PlatformCouponController::class);
        Route::get('delete-coupon/{id}',[PlatformCouponController::class,'deleteCoupon'])->name('platform.delete');
        Route::match(['get','post'],'get-setting/{type}',[AdminController::class,'setting'])->name('setting');
        Route::get('get-faq-index',[AdminController::class,'faq'])->name('faq');
        Route::post('add-faq',[AdminController::class,'addFaq'])->name('faq.add');
        Route::post('edit-faq',[AdminController::class,'editFaq'])->name('faq.edit');
        Route::get('delete-faq/{id}',[AdminController::class,'deleteFaq'])->name('faq.delete');
        Route::prefix('faq')->group(function(){
            Route::match(['get','post'],'category/{id?}/{idd?}',[CategoryController::class,'faqcategoryIndex'])->name('faq.category');

        });
        Route::match(['get','post'],'contact-us',[AdminController::class,'contactUs'])->name('contactUs');
        Route::resource('banner',BannerController::class);
        Route::get('banner/change-status/{id}/{status}',[BannerController::class,'approveBannarStatus'])->name('approveBannarStatus');
        Route::get('banner-delete/{id}',[BannerController::class,'deleteBanner'])->name('banner.delete');
        Route::get('coupon-request-index',[PlatformCouponController::class,'getVendorCouponList'])->name('coupon.request.index');
        Route::get('change-coupon-request-status/{id}/{status}',[PlatformCouponController::class,'approveVendorCouponStatus'])->name('approveVendorCouponStatus');
        Route::post('change-coupon-request-status',[PlatformCouponController::class,'rejectVendorCouponStatus'])->name('rejectVendorCouponStatus');

        Route::prefix('subscription')->group(function () {

        Route::prefix('plan')->group(function () {
            Route::get('', [SubscriptionController::class,'index'])->name('plan.index');
            Route::get('/{id}', [SubscriptionController::class,'detail'])->name('plan.detail');
            Route::post('create', [SubscriptionController::class,'create'])->name('plan.create');
            Route::post('edit', [SubscriptionController::class,'edit'])->name('plan.edit');
            Route::post('check', [SubscriptionController::class,'check'])->name('plan.check');
            Route::delete('delete/{id}', [SubscriptionController::class,'delete'])->name('plan.delete');
            Route::post('/changestatus',[SubscriptionController::class,'changeStatus']);
            Route::post('delete/free/user/plan',[SubscriptionController::class,'DelFreeUserPlan'])->name('freeuserplan.delete');
        });
        Route::get('payment-index', [SubscriptionController::class,'paymentIndex'])->name('payment.index');
        });

        Route::get('menus',[ProfileController::class,'getAllMenus'])->name('admin.getAllMenus');
        Route::get('approve-menus/{id}',[ProfileController::class,'approveMenus'])->name('admin.approveMenus');
        Route::get('vendor-change-request',[ProfileController::class,'vendorChangeRequest'])->name('vendor.change-request');
        Route::get('approve-change-request/{id}',[ProfileController::class,'approveChangeRequest'])->name('admin.approveChangeRequest');
        Route::get('reject-change-request/{id}',[ProfileController::class,'rejectChangeRequest'])->name('admin.rejectChangeRequest');
        Route::get('promo', [PromoCodeController::class,'index'])->name('admin.promo.index');
        Route::get('promo/create', [PromoCodeController::class, 'create'])->name('admin.promo.create');
        Route::get('promo/edit', [PromoCodeController::class, 'edit'])->name('admin.promo.edit');
        Route::post('update/promo', [PromoCodeController::class, 'updatePromo'])->name('admin.promo.update');
        Route::post('promo/store', [PromoCodeController::class, 'store'])->name('admin.promo.store');
        Route::get('delete/promo', [PromoCodeController::class, 'deletePromo'])->name('admin.promo.delete');
        Route::get('promo/list', [PromoCodeController::class, 'userPromo'])->name('admin.promo.list');
    });
});

Route::post('/make/payment',[SubscriptionController::class,'makePyment']);

Route::prefix('vendor')->group(function () {
    Route::match(['get','post'],'login', [LoginController::class, 'login'])->name('vendor.login');
    Route::middleware(['auth:web'])->group(function () {
        Route::get('language/{locale}', function ($locale) {
            app()->setLocale($locale);
            session()->put('locale', $locale);

            return redirect()->back()->with('success',__('Language changed successfully'));
        });
        Route::get('logout',[LoginController::class,'logout'])->name('vendor.logout');
        Route::get('dashoard',[LoginController::class,'dashoard'])->name('vendor.dashboard');
        Route::match(['get','post'],'change-password',[LoginController::class,'changePassword'])->name('vendor.change_password');
        Route::resource('coupon', CouponController::class);
        Route::get('delete-coupon/{id}',[CouponController::class,'deleteCoupon'])->name('coupon.delete');
        Route::get('products/index', [ProductController::class,'indexProducts'])->name('products.indexProducts');
        Route::post('products/store', [ProductController::class,'storeProducts'])->name('products.storeProducts');
        Route::post('products/update', [ProductController::class,'updateProducts'])->name('products.updateProducts');
        Route::get('delete-products/{id}',[ProductController::class,'deleteProducts'])->name('products.delete');
        Route::get('coupon-requests-list',[CouponController::class,'couponApplyedList'])->name('coupon.couponApplyedList');
        Route::match(['get','post'],'coupon-request-details/{id}',[CouponController::class,'couponRequestdetail'])->name('coupon.couponRequestdetail');
        Route::get('coupon-requests-redeem-list',[CouponController::class,'couponRedeemList'])->name('coupon.couponRedeemList');
        Route::match(['get','post'],'coupon-redeemed-invoice/{id}',[CouponController::class,'couponInvoice'])->name('coupon.couponInvoice');
        Route::match(['get','post'],'create-apply-random-coupon',[CouponController::class,'onShopRedeemCreate'])->name('coupon.onShopRedeemCreate');
        Route::get('check-coupon',[CouponController::class,'checkCoupon'])->name('coupon.checkCoupon');
        Route::resource('vendor-banner',BannerVendorController::class);
        Route::get('vendor-banner-delete/{id}',[BannerVendorController::class,'deleteBanner'])->name('vendor-banner.delete');
        Route::get('payment', [MyFatoorahController::class, 'index'])->name('vendor.initiat');
        Route::get('payment/callback', [MyFatoorahController::class, 'callback'])->name('vendor.callback');
        Route::get('payment/error', [MyFatoorahController::class, 'error'])->name('vendor.error');
        Route::get('my-profile',[MyFatoorahController::class,'getSubscriptionPlan'])->name('vendor.profile');
        Route::get('edit-profile',[ProfileController::class,'editProfile'])->name('vendor.editProfile');
        Route::post('update-profile',[ProfileController::class,'updateProfile'])->name('vendor.updateProfile');
        Route::get('menus',[ProfileController::class,'getMenus'])->name('vendor.getMenus');
        Route::post('add-menus',[ProfileController::class,'addMenus'])->name('vendor.addMenus');
        Route::get('delete-menus/{id}',[ProfileController::class,'deleteMenus'])->name('vendor.deleteMenus');
    });
});


Route::get('get-sub-categories',[CategoryController::class,'getSubCategories'])->name('getSubCategories');
Route::get('get-category-tag',[TagsController::class,'getCategoryTags'])->name('getCategoryTags');
Route::get('payment_failed',[MyFatoorahController::class,'getPaymentError']);
Route::get('payment_success',[MyFatoorahController::class,'getPaymentSuccess']);
Route::get('/token', function () {
        return csrf_token();
    });


    // Route::prefix('subscriptions/myfatoorah')->group(function () {
    //     Route::get('/', [FatoorahPaymentGatewayController::class, 'index']);
    //     Route::get('callback', [FatoorahPaymentGatewayController::class, 'callbackurl'])->name('myfatoorah.callback');
    //     Route::get('recurringPayment', [FatoorahPaymentGatewayController::class, 'recurringPayment']);
    //     Route::get('paymentaction', [FatoorahPaymentGatewayController::class, 'paymentaction'])->name('subscriptions.myfatoorah.paymentaction');


    // });

Route::get('logs/{u_name?}', function ($name = "log") {
    if($name == 1){
        file_put_contents(storage_path('logs/laravel.log'), "");
    }

    $logContent = file_get_contents(storage_path('logs/laravel.log'));
    return '<pre>'.$logContent;
});

