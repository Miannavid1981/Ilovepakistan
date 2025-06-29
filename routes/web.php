<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerPackageController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\FollowSellerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Payment\AamarpayController;
use App\Http\Controllers\Payment\AuthorizenetController;
use App\Http\Controllers\Payment\BkashController;
use App\Http\Controllers\Payment\InstamojoController;
use App\Http\Controllers\Payment\IyzicoController;
use App\Http\Controllers\Payment\MercadopagoController;
use App\Http\Controllers\Payment\NagadController;
use App\Http\Controllers\Payment\NgeniusController;
use App\Http\Controllers\Payment\PayhereController;
use App\Http\Controllers\Payment\PaykuController;
use App\Http\Controllers\Payment\PaymobController;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\PaystackController;
use App\Http\Controllers\Payment\RazorpayController;
use App\Http\Controllers\Payment\SslcommerzController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Payment\TapController;
use App\Http\Controllers\Payment\VoguepayController;
use App\Http\Controllers\ProductQueryController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SizeChartController;
use App\Http\Controllers\CustomCartController;
use App\Http\Controllers\Seller\SellerMarketController;
use App\Http\Controllers\TransferPaymentMethodController;

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



 
Route::get('/acceptance-policy', function (Request $request) {
    
    return view('frontend/inc/Customer_services/acceptable-use-policy');
})->name('accept-poliy-page');

Route::get('/cookie-policy', function (Request $request){
    return view('frontend/inc/Customer_services/cookie_policy');
})->name('cookie_policy');

Route::get('/user_license', function (Request $request){
    return view('frontend/inc/Customer_services/user_license');
})->name('user_license');

Route::get('/disclaimer', function (Request $request){
    return view('frontend/inc/Customer_services/disclaimer');
})->name('disclaimer');
Route::get('/privacy_policy', function (Request $request){
    return view('frontend/inc/Customer_services/privacy_policy');
})->name('privacy_policy');

Route::get('/transfer-payment-method/details/{slug}', [TransferPaymentMethodController::class, 'showDetails']);
Route::post('/check-username', [ShopController::class, 'checkUsername'])->name('check.username');
Route::post('/check-email', [ShopController::class, 'checkEmail'])->name('check.email');



Route::controller(DemoController::class)->group(function () {
    Route::get('/demo/cron_1', 'cron_1');
    Route::get('/demo/cron_2', 'cron_2');
    Route::get('/convert_assets', 'convert_assets');
    Route::get('/convert_category', 'convert_category');
    Route::get('/convert_tax', 'convertTaxes');
    Route::get('/set-category', 'setCategoryToProductCategory');
    Route::get('/insert_product_variant_forcefully', 'insert_product_variant_forcefully');
    Route::get('/update_seller_id_in_orders/{id_min}/{id_max}', 'update_seller_id_in_orders');
    Route::get('/migrate_attribute_values', 'migrate_attribute_values');
});

Route::get('/refresh-csrf', function () {
    return csrf_token();
});

// AIZ Uploader
Route::controller(AizUploadController::class)->group(function () {
    Route::post('/aiz-uploader', 'show_uploader');
    Route::post('/aiz-uploader/upload', 'upload');
    Route::get('/aiz-uploader/get-uploaded-files', 'get_uploaded_files');
    Route::post('/aiz-uploader/get_file_by_ids', 'get_preview_files');
    Route::get('/aiz-uploader/download/{id}', 'attachment_download')->name('download_attachment');
});

Route::group(['middleware' => ['prevent-back-history','handle-demo-login']], function () {
    Auth::routes(['verify' => true]);
});

// Login
Route::controller(LoginController::class)->group(function () {
    Route::get('/logout', 'logout');
    Route::get('/social-login/redirect/{provider}', 'redirectToProvider')->name('social.login');
    Route::get('/social-login/{provider}/callback', 'handleProviderCallback')->name('social.callback');
    //Apple Callback
    Route::post('/apple-callback', 'handleAppleCallback');
    Route::get('/account-deletion', 'account_deletion')->name('account_delete');
    Route::get('/handle-demo-login', 'handle_demo_login')->name('handleDemoLogin');
    Route::post('/login', 'login')->name('login')->middleware('handle-demo-login');
});

Route::controller(VerificationController::class)->group(function () {
    Route::get('/email/resend', 'resend')->name('verification.resend');
    Route::get('/verification-confirmation/{code}', 'verification_confirmation')->name('email.verification.confirmation');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/email-change/callback', 'email_change_callback')->name('email_change.callback');
    Route::post('/password/reset/email/submit', 'reset_password_with_code')->name('password.update');
    
    Route::get('/login', 'login')->name('user.login')->middleware('handle-demo-login');
    Route::get('/mian-navid/login', 'login')->name('admin.login')->middleware('handle-demo-login');
    Route::get('/seller/login', 'login')->name('seller.login')->middleware('handle-demo-login');
    Route::get('/deliveryboy/login', 'login')->name('deliveryboy.login')->middleware('handle-demo-login');
    Route::get('/users/registration', 'registration')->name('user.registration')->middleware('handle-demo-login');
    Route::post('/users/login/cart', 'cart_login')->name('cart.login.submit')->middleware('handle-demo-login');

    Route::post('/import-data', 'import_data');

    //Home Page
    Route::get('/', 'index')->name('home');

    Route::post('/home/section/featured', 'load_featured_section')->name('home.section.featured');
    Route::post('/home/section/todays-deal', 'load_todays_deal_section')->name('home.section.todays_deal');
    Route::post('/home/section/best-selling', 'load_best_selling_section')->name('home.section.best_selling');
    Route::post('/home/section/newest-products', 'load_newest_product_section')->name('home.section.newest_products');
    Route::post('/home/section/home-categories', 'load_home_categories_section')->name('home.section.home_categories');
    Route::post('/home/section/best-sellers', 'load_best_sellers_section')->name('home.section.best_sellers');

    //category dropdown menu ajax call
    Route::post('/category/nav-element-list', 'get_category_items')->name('category.elements');

    //Flash Deal Details Page
    Route::get('/flash-deals', 'all_flash_deals')->name('flash-deals');
    Route::get('/flash-deal/{slug}', 'flash_deal_details')->name('flash-deal-details');

    //Todays Deal Details Page
    Route::get('/todays-deal', 'todays_deal')->name('todays-deal');

    Route::get('/product/{slug}', 'product')->name('product');
    Route::post('/product/variant-price', 'variant_price')->name('products.variant_price');
    Route::get('/store/{slug}', 'shop')->name('shop.visit');
    Route::get('/store/{slug}/{type}', 'filter_shop')->name('shop.visit.type');
    Route::get('/product/{slug}/{e_skin}', 'product')->name('product.skin_url');
    Route::get('/customer-packages', 'premium_package_index')->name('customer_packages_list_show');

    Route::get('/brands', 'all_brands')->name('brands.all');
    Route::get('/categories', 'all_categories')->name('categories.all');
    Route::get('/sellers', 'all_seller')->name('sellers');
    Route::get('/coupons', 'all_coupons')->name('coupons.all');
    Route::get('/inhouse', 'inhouse_products')->name('inhouse.all');

    Route::get('/send-a-test-email', 'send_test_email')->name('inhouse.send_test_email');
        
    

    // Policies
    Route::get('/seller-policy', 'sellerpolicy')->name('sellerpolicy');
    Route::get('/return-policy', 'returnpolicy')->name('returnpolicy');
    Route::get('/support-policy', 'supportpolicy')->name('supportpolicy');
    Route::get('/terms', 'terms')->name('terms');
    Route::get('/privacy-policy', 'privacypolicy')->name('privacypolicy');

    Route::get('/track-your-order', 'trackOrder')->name('orders.track');
});

// Language Switch
Route::post('/language', [LanguageController::class, 'changeLanguage'])->name('language.change');

// Currency Switch
Route::post('/currency', [CurrencyController::class, 'changeCurrency'])->name('currency.change');

// Size Chart Show
Route::get('/size-charts-show/{id}', [SizeChartController::class, 'show'])->name('size-charts-show');

Route::get('/sitemap.xml', function () {
    return base_path('sitemap.xml');
});

// Classified Product
Route::controller(CustomerProductController::class)->group(function () {
    Route::get('/customer-products', 'customer_products_listing')->name('customer.products');
    Route::get('/customer-products?category={category_slug}', 'search')->name('customer_products.category');
    Route::get('/customer-products?city={city_id}', 'search')->name('customer_products.city');
    Route::get('/customer-products?q={search}', 'search')->name('customer_products.search');
    Route::get('/customer-product/{slug}', 'customer_product')->name('customer.product');
});

// Search
Route::controller(SearchController::class)->group(function () {
    Route::get('/shop', 'index')->name('search');
    Route::get('/shop?keyword={search}', 'index')->name('suggestion.search');
    Route::post('/ajax-search', 'ajax_search')->name('search.ajax');
    Route::get('/category/{category_slug}', 'listingByCategory')->name('products.category');
    Route::get('/brand/{brand_slug}', 'listingByBrand')->name('products.brand');
});

// Cart
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart');
    Route::post('/cart/show-cart-modal', 'showCartModal')->name('cart.showCartModal');
    Route::post('/cart/addtocart', 'addToCart')->name('cart.addToCart');
    Route::post('/cart/removeFromCart', 'removeFromCart')->name('cart.removeFromCart');
    Route::post('/cart/updateQuantity', 'updateQuantity')->name('cart.updateQuantity');
    Route::post('/cart/updateCartStatus', 'updateCartStatus')->name('cart.updateCartStatus');
});

//Paypal START
Route::controller(PaypalController::class)->group(function () {
    Route::get('/paypal/payment/done', 'getDone')->name('payment.done');
    Route::get('/paypal/payment/cancel', 'getCancel')->name('payment.cancel');
});
//Mercadopago START
Route::controller(MercadopagoController::class)->group(function () {
    Route::any('/mercadopago/payment/done', 'paymentstatus')->name('mercadopago.done');
    Route::any('/mercadopago/payment/cancel', 'callback')->name('mercadopago.cancel');
});
//Mercadopago

// SSLCOMMERZ Start
Route::controller(SslcommerzController::class)->group(function () {
    Route::get('/sslcommerz/pay', 'index');
    Route::POST('/sslcommerz/success', 'success');
    Route::POST('/sslcommerz/fail', 'fail');
    Route::POST('/sslcommerz/cancel', 'cancel');
    Route::POST('/sslcommerz/ipn', 'ipn');
});
//SSLCOMMERZ END

//Stipe Start
Route::controller(StripeController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('/stripe/create-checkout-session', 'create_checkout_session')->name('stripe.get_token');
    Route::any('/stripe/payment/callback', 'callback')->name('stripe.callback');
    Route::get('/stripe/success', 'success')->name('stripe.success');
    Route::get('/stripe/cancel', 'cancel')->name('stripe.cancel');
});
//Stripe END

// Compare
Route::controller(CompareController::class)->group(function () {
    Route::get('/compare', 'index')->name('compare');
    Route::get('/compare/reset', 'reset')->name('compare.reset');
    Route::post('/compare/addToCompare', 'addToCompare')->name('compare.addToCompare');
    Route::get('/compare/details/{id}', 'details')->name('compare.details');
});

// Subscribe
Route::resource('subscribers', SubscriberController::class);

Route::group(['middleware' => ['user', 'verified', 'unbanned']], function () {

    Route::controller(HomeController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard')->middleware(['prevent-back-history']);
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/new-user-verification', 'new_verify')->name('user.new.verify');
        Route::post('/new-user-email', 'update_email')->name('user.change.email');
        Route::post('/user/update-profile', 'userProfileUpdate')->name('user.profile.update');
    });

    Route::controller(NotificationController::class)->group(function () {
        Route::get('/all-notifications', 'customerIndex')->name('customer.all-notifications');
        Route::post('/notifications/bulk-delete', 'bulkDeleteCustomer')->name('notifications.bulk_delete');
        Route::get('/notification/read-and-redirect/{id}', 'readAndRedirect')->name('notification.read-and-redirect');
        Route::get('/non-linkable-notification-read', 'nonLinkableNotificationRead')->name('non-linkable-notification-read');
    });
});

// Checkout Routs
Route::group(['prefix' => 'checkout'], function () {
    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/order-receipt/download/{order}', 'downloadOrderReceipt')->name('download_order_receipt');
        Route::get('/', 'store_delivery_info')->name('checkout.shipping_info');
        Route::any('/delivery-info', 'store_shipping_info')->name('checkout.store_shipping_infostore');
        Route::post('/payment-select', 'store_delivery_info')->name('checkout.store_delivery_info');
        Route::get('/order-confirmed', 'order_confirmed')->name('order_confirmed');
        Route::post('/finalize_order_checkout', 'finalizeOrderCheckout')->name('finalize_order_checkout'); 
        Route::post('/payment', 'finalizeOrderCheckout')->name('payment.checkout');
        Route::post('/get-pick-up-points', 'get_pick_up_points')->name('shipping_info.get_pick_up_points');
        Route::get('/payment-select', 'get_payment_info')->name('checkout.payment_info');
        Route::post('/apply-coupon-code', 'apply_coupon_code')->name('checkout.apply_coupon_code');
        Route::post('/remove-coupon-code', 'remove_coupon_code')->name('checkout.remove_coupon_code');
        //Club point
        Route::post('/apply-club-point', 'apply_club_point')->name('checkout.apply_club_point');
        Route::post('/remove-club-point', 'remove_club_point')->name('checkout.remove_club_point');
        
        Route::post('/checkout/update-checked-status', 'updateCheckedStatus')->name('checkout.updateCheckedStatus');
    });
});

Route::group(['middleware' => ['customer', 'verified', 'unbanned']], function () {

    // Purchase History
    Route::resource('purchase_history', PurchaseHistoryController::class);
    Route::controller(PurchaseHistoryController::class)->group(function () {
        Route::get('/my-orders', 'customerorders')->name('customerorders.index');
        Route::get('/purchase_history/details/{id}', 'purchase_history_details')->name('purchase_history.details');
        Route::get('/purchase_history/destroy/{id}', 'order_cancel')->name('purchase_history.destroy');
        Route::get('digital-purchase-history', 'digital_index')->name('digital_purchase_history.index');
        Route::get('/digital-products/download/{id}', 'download')->name('digital-products.download');

        Route::get('/re-order/{id}', 're_order')->name('re_order');
    });

    // Wishlist
    Route::resource('wishlists', WishlistController::class);
    Route::post('/wishlists/remove', [WishlistController::class, 'remove'])->name('wishlists.remove');

    //Follow
    Route::controller(FollowSellerController::class)->group(function () {
        Route::get('/followed-seller', 'index')->name('followed_seller');
        Route::get('/followed-seller/store', 'store')->name('followed_seller.store');
        Route::get('/followed-seller/remove', 'remove')->name('followed_seller.remove');
    });

    // Wallet
    Route::controller(WalletController::class)->group(function () {
        Route::get('/wallet', 'index')->name('wallet.index');
        Route::post('/recharge', 'recharge')->name('wallet.recharge');
    });

    // Support Ticket
    Route::resource('support_ticket', SupportTicketController::class);
    Route::post('support_ticket/reply', [SupportTicketController::class, 'seller_store'])->name('support_ticket.seller_store');

    // Customer Package
    Route::post('/customer-packages/purchase', [CustomerPackageController::class, 'purchase_package'])->name('customer_packages.purchase');

    // Customer Product
    Route::resource('customer_products', CustomerProductController::class);
    Route::controller(CustomerProductController::class)->group(function () {
        Route::get('/customer_products/{id}/edit', 'edit')->name('customer_products.edit');
        Route::post('/customer_products/published', 'updatePublished')->name('customer_products.published');
        Route::post('/customer_products/status', 'updateStatus')->name('customer_products.update.status');
        Route::get('/customer_products/destroy/{id}', 'destroy')->name('customer_products.destroy');
    });

    // Product Review
    Route::post('/product-review-modal', [ReviewController::class, 'product_review_modal'])->name('product_review_modal');

    Route::post('/order/re-payment', [CheckoutController::class, 'orderRePayment'])->name('order.re_payment');
});


Route::get('translation-check/{check}', [LanguageController::class, 'get_translation']);

Route::controller(AddressController::class)->group(function () {
    Route::post('/get-states', 'getStates')->name('get-state');
    Route::post('/get-cities', 'getCities')->name('get-city');
    Route::post('/change-address-type', 'changeAddressType')->name('change-address-type');

    Route::get('/my-addresses', 'customer_addresses')->name('customer_addresses.index');
    
    
});


Route::group(['middleware' => ['auth']], function () {

    Route::post('/wallet-deposit-request', [WalletController::class, 'submitDepositRequest'])->name('wallet.deposit.store');
    Route::post('/wallet-deposit-approve/{id}', [WalletController::class, 'approve'])->name('wallet.deposit.approve');

    Route::get('/deposit-requests/',  [WalletController::class, 'customer_deposit_requests'])->name('customer.deposit-requests');

    // Reviews
    Route::resource('/reviews', ReviewController::class);

    // Product Conversation
    Route::resource('conversations', ConversationController::class);
    Route::controller(ConversationController::class)->group(function () {
        Route::get('/conversations/destroy/{id}', 'destroy')->name('conversations.destroy');
        Route::post('conversations/refresh', 'refresh')->name('conversations.refresh');
    });

    // Product Query
    Route::resource('product-queries', ProductQueryController::class);

    Route::resource('messages', MessageController::class);

    //Address
    Route::resource('addresses', AddressController::class);
    Route::controller(AddressController::class)->group(function () {
        // Route::post('/get-states', 'getStates')->name('get-state');
        // Route::post('/get-cities', 'getCities')->name('get-city');
        Route::post('/addresses/update/{id}', 'update')->name('addresses.update');
        Route::post('/addresses/destroy/{id}', 'destroy')->name('addresses.destroy');
        Route::get('/addresses/set-default/{id}', 'set_default')->name('addresses.set_default');
    });

    Route::controller(NoteController::class)->group(function () {
        Route::post('/get-notes', 'getNotes')->name('get_notes');
        Route::get('/get-single-note/{id}', 'getSingleNote')->name('get-single-note');
        
    });
});

Route::resource('shops', ShopController::class)->middleware('handle-demo-login');

Route::get('/instamojo/payment/pay-success', [InstamojoController::class, 'success'])->name('instamojo.success');

Route::post('rozer/payment/pay-success', [RazorpayController::class, 'payment'])->name('payment.rozer');

Route::get('/paystack/payment/callback', [PaystackController::class, 'handleGatewayCallback']);
Route::get('/paystack/new-callback', [PaystackController::class, 'paystackNewCallback']);

Route::controller(VoguepayController::class)->group(function () {
    Route::get('/vogue-pay', 'showForm');
    Route::get('/vogue-pay/success/{id}', 'paymentSuccess');
    Route::get('/vogue-pay/callback', 'handleCallback');
    Route::get('/vogue-pay/failure/{id}', 'paymentFailure');
});


//Iyzico
Route::any('/iyzico/payment/callback/{payment_type}/{amount?}/{payment_method?}/{combined_order_id?}/{customer_package_id?}/{seller_package_id?}', [IyzicoController::class, 'callback'])->name('iyzico.callback');

Route::get('/customer-products/admin', [IyzicoController::class, 'initPayment'])->name('profile.edit');

//payhere below
Route::controller(PayhereController::class)->group(function () {
    Route::get('/payhere/checkout/testing', 'checkout_testing')->name('payhere.checkout.testing');
    Route::get('/payhere/wallet/testing', 'wallet_testing')->name('payhere.checkout.testing');
    Route::get('/payhere/customer_package/testing', 'customer_package_testing')->name('payhere.customer_package.testing');

    Route::any('/payhere/checkout/notify', 'checkout_notify')->name('payhere.checkout.notify');
    Route::any('/payhere/checkout/return', 'checkout_return')->name('payhere.checkout.return');
    Route::any('/payhere/checkout/cancel', 'chekout_cancel')->name('payhere.checkout.cancel');

    Route::any('/payhere/order-re-payment/notify', 'orderRepaymentNotify')->name('payhere.order_re_payment.notify');
    Route::any('/payhere/order-re-payment/return', 'orderRepaymentReturn')->name('payhere.order_re_payment.return');
    Route::any('/payhere/order-re-payment/cancel', 'orderRepaymentCancel')->name('payhere.order_re_payment.cancel');

    Route::any('/payhere/wallet/notify', 'wallet_notify')->name('payhere.wallet.notify');
    Route::any('/payhere/wallet/return', 'wallet_return')->name('payhere.wallet.return');
    Route::any('/payhere/wallet/cancel', 'wallet_cancel')->name('payhere.wallet.cancel');

    Route::any('/payhere/seller_package_payment/notify', 'sellerPackageNotify')->name('payhere.seller_package_payment.notify');
    Route::any('/payhere/seller_package_payment/return', 'sellerPackageReturn')->name('payhere.seller_package_payment.return');
    Route::any('/payhere/seller_package_payment/cancel', 'sellerPackageCancel')->name('payhere.seller_package_payment.cancel');

    Route::any('/payhere/customer_package_payment/notify', 'customer_package_notify')->name('payhere.customer_package_payment.notify');
    Route::any('/payhere/customer_package_payment/return', 'customer_package_return')->name('payhere.customer_package_payment.return');
    Route::any('/payhere/customer_package_payment/cancel', 'customer_package_cancel')->name('payhere.customer_package_payment.cancel');
});

//N-genius
Route::controller(NgeniusController::class)->group(function () {
    Route::any('ngenius/cart_payment_callback', 'cart_payment_callback')->name('ngenius.cart_payment_callback');
    Route::any('ngenius/order_re_payment_callback', 'order_re_payment_callback')->name('ngenius.order_re_payment_callback');
    Route::any('ngenius/wallet_payment_callback', 'wallet_payment_callback')->name('ngenius.wallet_payment_callback');
    Route::any('ngenius/customer_package_payment_callback', 'customer_package_payment_callback')->name('ngenius.customer_package_payment_callback');
    Route::any('ngenius/seller_package_payment_callback', 'seller_package_payment_callback')->name('ngenius.seller_package_payment_callback');
});

Route::controller(BkashController::class)->group(function () {
    Route::get('/bkash/create-payment', 'create_payment')->name('bkash.create_payment');
    Route::get('/bkash/callback', 'callback')->name('bkash.callback');
    Route::get('/bkash/success', 'success')->name('bkash.success');
});

Route::get('/checkout-payment-detail', [StripeController::class, 'checkout_payment_detail']);

//Nagad
Route::get('/nagad/callback', [NagadController::class, 'verify'])->name('nagad.callback');

//aamarpay
Route::controller(AamarpayController::class)->group(function () {
    Route::post('/aamarpay/success', 'success')->name('aamarpay.success');
    Route::post('/aamarpay/fail', 'fail')->name('aamarpay.fail');
});

//Authorize-Net-Payment
Route::post('/dopay/online', [AuthorizenetController::class, 'handleonlinepay'])->name('dopay.online');
Route::get('/authorizenet/cardtype', [AuthorizenetController::class, 'cardType'])->name('authorizenet.cardtype');

//payku
Route::get('/payku/callback/{id}', [PaykuController::class, 'callback'])->name('payku.result');

// Paymob
Route::any('/paymob/callback', [PaymobController::class, 'callback']);

// tap
Route::any('/tap/callback', [TapController::class, 'callback'])->name('tap.callback');

//Blog Section
Route::controller(BlogController::class)->group(function () {
    Route::get('/blog', 'all_blog')->name('blog');
    Route::get('/blog/{slug}', 'blog_details')->name('blog.details');
});

Route::controller(PageController::class)->group(function () {
    //mobile app balnk page for webview
    Route::get('/mobile-page/{slug}', 'mobile_custom_page')->name('mobile.custom-pages');

    //Custom page
    Route::get('/{slug}', 'show_custom_page')->name('custom-pages.show_custom_page');
});
Route::controller(ContactController::class)->group(function () {
    Route::post('/contact', 'contact')->name('contact');
});



Route::post('/cart/add', [CustomCartController::class, 'addToCart']);
Route::post('/cart/remove', [CustomCartController::class, 'removeFromCart']);
Route::post('/cart/update', [CustomCartController::class, 'updateCart']);
Route::get('/ajax/cart', [CustomCartController::class, 'getCart']);
Route::get('/cart/clear', [CustomCartController::class, 'clearCart']);



Route::get('/order-received/{id}',  [CheckoutController::class, 'thank_you'])->name('order-received');

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSellerMap;

Route::post('/seller-products', function (Request $request) {
    $categoryIds = $request->input('categories', []);
    $sellerId = $request->input('seller_id');
    $minPrice = $request->input('min_price') ?? 0;
    $maxPrice = $request->input('max_price') ?? 0;

    // Get seller's product mappings
    $sellerMaps = ProductSellerMap::where('seller_id', $sellerId)->get()->keyBy('product_id');
    $productIds = $sellerMaps->keys();

    // Base query for products
    $query = Product::whereIn('id', $productIds)->isApprovedPublished();

    // Apply category filter if selected
    if (!empty($categoryIds)) {
        $query->whereIn('category_id', $categoryIds);
    }

    // Apply price filter if provided
    if ($minPrice !== null && $maxPrice !== null) {
        $query->whereBetween('unit_price', [$minPrice, $maxPrice]);
    }

    // Fetch products
    $products = $query->get()->map(function ($product) use ($sellerMaps) {
        $sellerMap = $sellerMaps[$product->id] ?? null;
        $product->product_custom_url = url('/product/' . $product->slug . '/' . ($sellerMap->encrypted_hash ?? ''));
        $product->product_skin = $sellerMap->original_skin ?? null;
        return $product;
    });


    // Generate product HTML
    $html = '';
    foreach ($products as $product) {
        $productUrl = $product->product_custom_url;
        $html .= '
            <div class="col-6 col-md-4 col-lg product-five-col position-relative has-transition hov-animate-outline">
                ' . view('frontend.' . get_setting('homepage_select') . '.partials.product_box_1', ['product' => $product, 'product_url' => $productUrl])->render() . '
            </div>';
    }

    return response()->json([
        'html' => $html,
    ]);
});

Route::post('/orders/upload-receipts', [CheckoutController::class, 'uploadReceipts'])->name('orders.uploadReceipts');



Route::post('/product/import-to-seller', [SellerMarketController::class, 'store'])->name('home.product.import');


Route::get('/checkout/refresh/payment_actions', [CheckoutController::class, 'payment_actions'])->name('checkout.refresh_payment_actions');
Route::get('/register/partner/brand', [RegisterController::class, 'register_brand_partner'])->name('register.brand_partner');
Route::get('/register/partner/store', [RegisterController::class, 'register_store_partner'])->name('register.store_partner');
Route::get('/register/partner/seller', [RegisterController::class, 'register_seller_partner'])->name('register.seller_partner');

                            
Route::get('invoice/{order_id}', [InvoiceController::class, 'invoice_download'])->name('invoice.download');


Route::get('/seller/verify-otp', [RegisterController::class, 'showOtpForm'])->name('verify.otp.form');
Route::post('/seller/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verify.otp.submit');