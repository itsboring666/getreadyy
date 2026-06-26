<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ProductDisplayController;
use App\Http\Controllers\CategoryPageController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\FeaturedProductController;
use App\Http\Controllers\Admin\NewArrivalController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\EmailSubscriptionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminOrderRequestsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;

// Homepage
Route::get('/', [HomeController::class, 'index']);

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/verify-otp', [OtpController::class, 'showVerificationForm'])->name('otp.verify.form');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
Route::post('/otp/resend', [OtpController::class, 'resend'])
    ->middleware('throttle:2,1') // 3 requests per minute
    ->name('otp.resend');

// Contact Us Page
Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/')->with('success', 'You have been logged out successfully.');
})->name('logout');

// Payment Gateways
Route::post('/webhook/razorpay', [\App\Http\Controllers\WebhookController::class, 'razorpayWebhook'])->name('webhook.razorpay');

// Product Routes
Route::get('/products', [ProductDisplayController::class, 'index'])->name('products.all');
Route::get('/product/{id}', [ProductDisplayController::class, 'view'])->name('product.view');
Route::get('/search/autocomplete', [ProductDisplayController::class, 'autocomplete'])->name('products.autocomplete');


Route::prefix('admin')->middleware('admin')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Carousel Routes
    Route::get('/carousels', [CarouselController::class, 'index'])->name('admin.carousels.index');
    Route::get('/carousels/create', [CarouselController::class, 'create'])->name('admin.carousels.create');
    Route::post('/carousels', [CarouselController::class, 'store'])->name('admin.carousels.store');
    Route::get('/carousels/{carousel}/edit', [CarouselController::class, 'edit'])->name('admin.carousels.edit');
    Route::put('/carousels/{carousel}', [CarouselController::class, 'update'])->name('admin.carousels.update');
    Route::delete('/carousels/{carousel}', [CarouselController::class, 'destroy'])->name('admin.carousels.destroy');

    // Featured Product Routes
    Route::get('/featured-product', [FeaturedProductController::class, 'index'])->name('admin.featured.index');
    Route::post('/featured-product', [FeaturedProductController::class, 'store'])->name('admin.featured.store');
    Route::put('/featured-product/{id}', [FeaturedProductController::class, 'update'])->name('admin.featured.update');
    Route::delete('/featured-product/{id}', [FeaturedProductController::class, 'destroy'])->name('admin.featured.destroy');

    // New Arrivals
    Route::get('/new-arrivals', [NewArrivalController::class, 'index'])->name('admin.new-arrivals.index');
    Route::post('/new-arrivals', [NewArrivalController::class, 'store'])->name('admin.new-arrivals.store');
    Route::put('/new-arrivals/{id}', [NewArrivalController::class, 'update'])->name('admin.new-arrivals.update');
    Route::delete('/new-arrivals/{id}', [NewArrivalController::class, 'destroy'])->name('admin.new-arrivals.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::post('/products/import', [ProductController::class, 'import'])->name('admin.products.import');

    // Emails
    Route::get('/emails', [EmailController::class, 'index'])->name('admin.emails.index');
    Route::post('/emails/send', [EmailController::class, 'send'])->name('admin.emails.send');
    Route::delete('/emails/{email}', [EmailController::class, 'destroy'])->name('admin.emails.destroy');

    // Contact Messages
    Route::get('/contact-messages', [\App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('admin.contact-messages.index');
    Route::get('/contact-messages/{contactMessage}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('admin.contact-messages.show');
    Route::delete('/contact-messages/{contactMessage}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('admin.contact-messages.destroy');

    //Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/requests', [AdminOrderRequestsController::class, 'index'])->name('admin.orders.requests');
    Route::get('/orders/{orderId}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{order}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::post('/orders/{id}/requests/approve', [AdminOrderRequestsController::class, 'approve'])->name('admin.orders.requests.approve');
    Route::post('/orders/{id}/requests/reject', [AdminOrderRequestsController::class, 'reject'])->name('admin.orders.requests.reject');
    Route::post('/orders/{order}/send-confirmation', [AdminOrderController::class, 'sendConfirmationEmail'])->name('admin.orders.sendConfirmation');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
});

Route::get('/admin/orders/{order}/invoice', [AdminOrderController::class, 'downloadInvoice'])
    ->middleware(['auth', 'admin'])
    ->name('admin.orders.invoice');


Route::post('/subscribe-email', [EmailSubscriptionController::class, 'store'])->name('email.subscribe');

Route::get('/cart', [CartController::class, 'view'])->name('cart');

Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/add-multiple', [CartController::class, 'addMultiple'])->name('cart.add-multiple');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Product Reviews
    Route::post('/product/{productId}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
Route::get('/thank-you/{orderId}', [CheckoutController::class, 'thankYou'])->name('checkout.thankyou');

Route::middleware(['auth'])->group(function () {
    Route::post('/subscribe', [EmailSubscriptionController::class, 'store'])->name('emails.subscribe');
    Route::delete('/unsubscribe', [EmailSubscriptionController::class, 'destroy'])->name('emails.unsubscribe');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/verify', [CheckoutController::class, 'verify'])->name('checkout.verify');
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
    Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');
    Route::get('/checkout/razorpay/{orderId}', [CheckoutController::class, 'razorpayCheckout'])->name('checkout.razorpay');
    Route::post('/checkout/razorpay/{orderId}/process', [CheckoutController::class, 'razorpayProcess'])->name('checkout.razorpay.process');
});

// 👇 For checkout thank-you invoice download (after placing an order)
Route::get('/order/invoice/{orderId}', [App\Http\Controllers\CheckoutController::class, 'downloadInvoice'])
    ->name('order.invoice.download')
    ->middleware('auth');

// 👇 For past orders (order history section)
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderId}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{orderId}/invoice', [App\Http\Controllers\OrderController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::post('/orders/{orderId}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{orderId}/return', [App\Http\Controllers\OrderController::class, 'requestReturn'])->name('orders.return');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Saved Address Book
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{id}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.default');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Static Pages
Route::get('/manifesto', function () {
    return view('frontend.manifesto');
})->name('manifesto');

Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

Route::get('/shipping-returns', function () {
    return view('frontend.shipping');
})->name('shipping');

// Outfit Builder
Route::get('/outfit-builder', [App\Http\Controllers\OutfitBuilderController::class, 'index'])->name('outfit-builder');

// Storage Redirect for Cloudinary
Route::get('/storage/{path}', function ($path) {
    if (config('filesystems.disks.public.driver') === 'cloudinary') {
        return Illuminate\Support\Facades\Redirect::away(Illuminate\Support\Facades\Storage::disk('public')->url($path));
    }
    abort(404);
})->where('path', '.*');

// Dynamic Category Route (must be last)
Route::get('/{slug}', [CategoryPageController::class, 'show'])->name('category.show');
