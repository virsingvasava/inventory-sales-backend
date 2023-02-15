<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotpasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\KioskController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CustomerFeedbackController;
use App\Http\Controllers\Admin\InsentiveController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FeedbackQuestionController;
use App\Http\Controllers\AirportManager\DashboardController as HeadOfDepartment;
use App\Http\Controllers\AirportManager\PendingRequestController;
use App\Http\Controllers\AirportManager\ProfileController  as Settings;
use App\Http\Controllers\AirportManager\RequestQtyController;
use App\Http\Controllers\AirportManager\StockQtyUpdateController;
use App\Http\Controllers\AirportManager\CityUsersController;


use App\Http\Controllers\Salesman\RegisterController;
use App\Http\Controllers\Salesman\DashboardController as DashboardSalesman;
use App\Http\Controllers\Salesman\ProfileController  as SalesmanProfile;
use App\Http\Controllers\Salesman\SalesHistoryController;
use Illuminate\Routing\Route as RoutingRoute;

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
// Auth::routes();
Route::get('/', function () {
    return view('auth/login');
});


Route::group(['middleware' => 'guest'], function ($router) {

	Route::get('/admin/login', [LoginController::class, 'index'])->name('login');
	Route::post('/login/submit', [LoginController::class, 'submit'])->name('login.submit');

	Route::get('/forgot-password', [ForgotpasswordController::class, 'index'])->name('forgot_password');
	Route::post('/forgot-password/submit', [ForgotpasswordController::class, 'submit'])->name('forgot_password.submit');

	Route::get('/reset-password/{token}', [ForgotpasswordController::class, 'index'])->name('auth.reset_password');
	Route::post('/password/submit', [ForgotpasswordController::class, 'submit'])->name('password.submit');

    Route::get('/salesman/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register/submit', [RegisterController::class, 'submit'])->name('register.submit');
  
});

Route::group(['middleware' => 'auth', 'namespace' => 'Admin' , 'prefix' => 'admin'], function ($router) {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/dashboard-ajax', [DashboardController::class, 'dashboard_ajax'])->name('admin.dashboard.ajax');
    Route::post('/dashboard-sales-payment-mode',[DashboardController::class, 'ajax_sales_payment_mode'])->name('admin.dashboard.sales_payment_mode');
    Route::post('/dashboard-airportChange',[DashboardController::class,'airportChange'])->name('admin.dashboard.airportChange');
    Route::post('/dashboard-product-comparison1',[DashboardController::class,'ajax_product_comparison_1'])->name('admin.dashboard.product_comparison_1');
    Route::post('/dashboard-product-comparison2',[DashboardController::class,'ajax_product_comparison_2'])->name('admin.dashboard.product_comparison_2');
    Route::post('/dashboard-product-comparison3',[DashboardController::class,'ajax_product_comparison_3'])->name('admin.dashboard.product_comparison_3');
    Route::post('/dashboard-product-comparison4',[DashboardController::class,'ajax_product_comparison_4'])->name('admin.dashboard.product_comparison_4');
    Route::post('/dashboard-sales-brand', [DashboardController::class, 'ajax_sales_by_brand_city'])->name('admin.dashboard.ajax_sales_by_brand_city');
    
    Route::post('/dashboard-sales-region', [DashboardController::class, 'ajax_sales_by_region'])->name('admin.dashboard.ajax_sales_by_region');
    
    Route::post('/dashboard-purchase-behaviour', [DashboardController::class, 'ajax_purchase_behaviour'])->name('admin.dashboard.ajax_purchase_behaviour');
    Route::post('/dashboard-purchase-behaviour-export',[DashboardController::class,'ajax_purchase_behaviour_export'])->name('admin.dashboard.ajax_purchase_behaviour_export');
    Route::post('/dashboard-sold-brand', [DashboardController::class, 'ajax_sold_brand'])->name('admin.dashboard.ajax_sold_brand');
    Route::get('/dashboard-brand-dashboard/{id}',[DashboardController::class, 'ajax_brand_dashboard'])->name('admin.dashboard.ajax_brand_dashboard');
    Route::post('/dashboard-brand-dashboard-post/{id}',[DashboardController::class, 'ajax_brand_dashboard_post'])->name('admin.dashboard.ajax_brand_dashboard_post');
    Route::post('/dashboard-brand-sales-history',[DashboardController::class, 'ajax_brand_sales_export'])->name('admin.dashboard.ajax_brand_dashboard_sales_export');
    Route::post('/dashboard-sales-by-location', [DashboardController::class, 'ajax_sales_by_location'])->name('admin.dashboard.ajax_sales_by_location');
    Route::post('/dashboard-sales-by-location-export',[DashboardController::class,'ajax_sales_by_loction_export'])->name('admin.dashboard.ajax_sales_by_location_export');
    Route::post('/dashboard-sales-by-time-interval',[DashboardController::class,'sales_by_time_interval'])->name('admin.dashboard.sales_by_time_interval');
    Route::post('/dashboard-sales-by-time-interval-kiosks',[DashboardController::class,'sales_by_time_interval_kiosk'])->name('admin.dashboard.sales_by_time_interval_kiosk');
    Route::post('/dashboard-top-ten-kiosk-export',[DashboardController::class,'ajax_top_ten_kiosk_export'])->name('admin.dashboard.ajax_top_ten_kiosk_export');
    
    Route::get('/dashboard-sales', [DashboardController::class, 'salesDashboard'])->name('admin.dashboard.sales');
    Route::post('/dashboard-sales-post', [DashboardController::class, 'salesDashboardPost'])->name('admin.dashboard.sales_post');
    Route::get ('/dashboard-sales-date/{date}',[DashboardController::class,'salesDashboardmonth'])->name('admin.dashboard.sales_month');
    Route::post('/dashboard-sales-date-export',[DashboardController::class,'salesDashboardmonthexport'])->name('admin.dashboard.sales_month_export');
    Route::get ('/dashboard-sales-day/{date}',[DashboardController::class,'salesDashboardday'])->name('admin.dashboard.sales_day');
    Route::post('/dashboard-sales-day-export',[DashboardController::class,'salesDashboarddayexport'])->name('admin.dashboard.sales_day_export');
    Route::post('/dashboard-sales-month-post',[DashboardController::class,'salesDashboardmonthpost'])->name('admin.dashboard.sales_monthpost');

    Route::get('/dashboard-kiosk',[DashboardController::class,'kioskDashboard'])->name('admin.dashboard.kiosk');
    Route::get('/dashboard-kiosk-qty.{id}',[DashboardController::class,'kiosk_qty'])->name('admin.dashboard.kiosk_qty');
    Route::post('/total_sales_by_region_export',[DashboardController::class,'total_sales_by_region_export'])->name('admin.dashboard.total_sales_by_region_export');

    //my new route
    Route::get('/insentive',[InsentiveController::class,'insentive'])->name('admin.dashboard.insentive');
    Route::post('/insentive-export',[InsentiveController::class,'insentiveExport'])->name('admin.insentive.export');
    //end new route

    Route::get('/oss-alert',[DashboardController::class,'oss_alert'])->name('admin.dashboard.oss_alert');
    Route::post('/oss-alert-post',[DashboardController::class,'oss_alert_post'])->name('admin.dashboard.ajax_oss_alert');
    Route::post('/oss-alert-kiosk-post',[DashboardController::class,'oss_alert_kiosk'])->name('admin.dashboard.ajax_oss_alert_kiosk');

    Route::post('/export_listing_data', [DashboardController::class, 'export_listing_data'])->name('admin.dashboard.export_listing_data');
    Route::post('/export_listing_data-post', [DashboardController::class, 'export_listing_data_post'])->name('admin.dashboard.export_listing_data_post');

    Route::get('/logout', [DashboardController::class, 'logout'])->name('admin.dashboard.logout');

    Route::group(['prefix' => 'settings'], function ($router) {
        Route::get('/', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::get('/profile', [SettingsController::class, 'profile'])->name('admin.settings.profile');
        Route::post('/profile-update', [SettingsController::class, 'profile_update'])->name('admin.settings.profile_update');
    });

    Route::group(['prefix' => 'profile'], function ($router) {
		Route::get('/', [ProfileController::class, 'profile'])->name('admin.profile.index');
		Route::post('/update', [ProfileController::class, 'profile_update'])->name('admin.profile.update');
	});

	Route::group(['prefix' => 'change-password'], function ($router) {
		Route::get('/', [ProfileController::class, 'change_password'])->name('admin.change_password');
		Route::post('/update', [ProfileController::class, 'change_password_submit'])->name('admin.change_password.update');
	});

	Route::group(['prefix' => 'support'], function ($router) {
		Route::get('/',  [SupportController::class, 'index'])->name('admin.support.index');
		Route::post('/submit', [SupportController::class, 'support_update'])->name('admin.support.support_update');
	});

	Route::group(['prefix' => 'inventory'], function ($router) {
        Route::get('/', [InventoryController::class, 'index'])->name('admin.inventory.index');
        Route::get('/create', [InventoryController::class, 'create'])->name('admin.inventory.create');
        Route::post('/store', [InventoryController::class, 'store'])->name('admin.inventory.store');
        Route::post('/delete', [InventoryController::class, 'delete'])->name('admin.inventory.delete');
        Route::get('/view/{id}',  [InventoryController::class, 'create'])->name('admin.inventory.view');
        Route::get('/edit/{id}',  [InventoryController::class, 'edit'])->name('admin.inventory.edit');
        Route::post('/update', [InventoryController::class, 'update'])->name('admin.inventory.update');
    });

    Route::group(['prefix' => 'kiosk'], function ($router) {
        Route::get('/', [KioskController::class, 'index'])->name('admin.kiosk.index');
        Route::get('/create', [KioskController::class, 'create'])->name('admin.kiosk.create');
        Route::post('/store', [KioskController::class, 'store'])->name('admin.kiosk.store');
        Route::post('/delete', [KioskController::class, 'destroy'])->name('admin.kiosk.delete');
        Route::get('/view/{id}',  [KioskController::class, 'view'])->name('admin.kiosk.view');
        Route::get('/edit/{id}',  [KioskController::class, 'edit'])->name('admin.kiosk.edit');
        Route::post('/update', [KioskController::class, 'update'])->name('admin.kiosk.update');
        Route::post('/import', [KioskController::class, 'kioskImport'])->name('admin.kiosk.import');
        Route::post('/export', [kioskController::class, 'kioskExport'])->name('admin.kiosk.export');
        Route::post('/export_listing_data', [kioskController::class, 'export_listing_data'])->name('admin.kiosk.export_listing_data');
        Route::get('/product_list_search', [kioskController::class, 'product_list_search'])->name('admin.kiosk.product_list_search');
        Route::get('/payment_mode_search', [kioskController::class, 'payment_mode_search'])->name('admin.kiosk.payment_mode_search');
    });

	Route::group(['prefix' => 'product'], function ($router) {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');

        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::post('/delete', [ProductController::class, 'delete'])->name('admin.product.delete');
        Route::get('/view/{id}',  [ProductController::class, 'create'])->name('admin.product.view');
        Route::get('/edit/{id}',  [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/update', [ProductController::class, 'update'])->name('admin.product.update');
        Route::post('/brand_product_delete', [ProductController::class, 'brand_product_delete'])->name('admin.product.brand_product_delete');


        Route::get('/brand/{id}',  [ProductController::class, 'productIndex'])->name('admin.product.brand.index');
		Route::get('/brand/{id}/create', [ProductController::class,'productCreate'])->name('admin.product.brand.create');
        Route::get('/brand/edit/{id}',  [ProductController::class, 'productEdit'])->name('admin.product.brand.edit');
        Route::post('/brand/update/{id}', [ProductController::class, 'productUpdate'])->name('admin.product.brand.update');
        Route::post('/brand/{id}/store', [ProductController::class, 'productStore'])->name('admin.product.brand.store');
        Route::get('/brand/view/{id}',  [ProductController::class, 'productView'])->name('admin.product.brand.view');
        Route::post('/brand/delete/{id}', [ProductController::class, 'productDestroy'])->name('admin.product.brand.delete');
        Route::post('/brand/import/{id}', [ProductController::class, 'productImport'])->name('admin.product.brand.import');
        Route::post('/brand/export/{id}', [ProductController::class, 'productExport'])->name('admin.product.brand.export');
    });
    
    Route::group(['prefix' => 'brand'], function ($router) {
        Route::get('/', [BrandController::class, 'index'])->name('admin.brand.index');
        Route::get('/create', [BrandController::class, 'create'])->name('admin.brand.create');
        Route::post('/store', [BrandController::class, 'store'])->name('admin.brand.store');
        Route::post('/delete', [BrandController::class, 'delete'])->name('admin.brand.delete');
        Route::get('/view/{id}',  [BrandController::class, 'create'])->name('admin.brand.view');
        Route::get('/edit/{id}',  [BrandController::class, 'edit'])->name('admin.brand.edit');
        Route::post('/update', [BrandController::class, 'update'])->name('admin.brand.update');
    });

    Route::group(['prefix' => 'user-management'], function ($router) {
        Route::get('/', [UserManagementController::class, 'index'])->name('admin.user_management.index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('admin.user_management.create');
        Route::post('/store', [UserManagementController::class, 'store'])->name('admin.user_management.store');
        Route::post('/destroy', [UserManagementController::class, 'destroy'])->name('admin.user_management.destroy');
        Route::get('/view/{id}',  [UserManagementController::class, 'view'])->name('admin.user_management.view');
        Route::get('/edit/{id}',  [UserManagementController::class, 'edit'])->name('admin.user_management.edit');
        Route::post('/update', [UserManagementController::class, 'update'])->name('admin.user_management.update');
        Route::get('/user-total',[UserManagementController::class, 'user_management_total'])->name('admin.user_management.user_management_total');
        Route::post('/user_status_update', [UserManagementController::class, 'user_status_update'])->name('admin.user_management.user_status_update');
        Route::post('/status_filter', [UserManagementController::class, 'status_filter'])->name('admin.user_management.status_filter');
        Route::post('/import', [UserManagementController::class, 'UsersImport'])->name('admin.user_management.import');
        Route::post('/export', [UserManagementController::class, 'UsersExport'])->name('admin.user_management.export');
        Route::post('/export_user_listing_data', [UserManagementController::class, 'export_user_listing_data'])->name('admin.user_management.export_user_listing_data');

    });

	Route::group(['prefix' => 'customer-feedback'], function ($router) {
        Route::get('/', [CustomerFeedbackController::class, 'index'])->name('admin.customer_feedback.index');
        Route::get('/create', [CustomerFeedbackController::class, 'create'])->name('admin.customer_feedback.create');
        Route::post('/store', [CustomerFeedbackController::class, 'store'])->name('admin.customer_feedback.store');
        Route::post('/delete', [CustomerFeedbackController::class, 'delete'])->name('admin.customer_feedback.delete');
        Route::get('/view/{id}',  [CustomerFeedbackController::class, 'create'])->name('admin.customer_feedback.view');
        Route::get('/edit/{id}',  [CustomerFeedbackController::class, 'edit'])->name('admin.customer_feedback.edit');
        Route::post('/update', [CustomerFeedbackController::class, 'update'])->name('admin.customer_feedback.update');
    });

    Route::group(['prefix' => 'notifications'], function ($router) {
        Route::get('/', [NotificationsController::class, 'index'])->name('admin.notifications.index');
        Route::get('/create', [NotificationsController::class, 'create'])->name('admin.notifications.create');
        Route::post('/store', [NotificationsController::class, 'store'])->name('admin.notifications.store');
        Route::post('/delete', [NotificationsController::class, 'delete'])->name('admin.notifications.delete');
        Route::get('/view/{id}',  [NotificationsController::class, 'create'])->name('admin.notifications.view');
        Route::get('/edit/{id}',  [NotificationsController::class, 'edit'])->name('admin.notifications.edit');
        Route::post('/update', [NotificationsController::class, 'update'])->name('admin.notifications.update');
    });

	Route::group(['prefix' => 'settings'], function ($router) {
        Route::get('/', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::get('/create', [SettingsController::class, 'create'])->name('admin.settings.create');
        Route::post('/store', [SettingsController::class, 'store'])->name('admin.settings.store');
        Route::post('/delete', [SettingsController::class, 'delete'])->name('admin.settings.delete');
        Route::get('/view/{id}',  [SettingsController::class, 'create'])->name('admin.settings.view');
        Route::get('/edit/{id}',  [SettingsController::class, 'edit'])->name('admin.settings.edit');
        Route::post('/update', [SettingsController::class, 'update'])->name('admin.settings.update');
    });

    Route::group(['prefix' => 'user'], function ($router) {
        Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::post('/delete', [UserController::class, 'delete'])->name('admin.user.delete');
        Route::get('/view/{id}',  [UserController::class, 'create'])->name('admin.user.view');
        Route::get('/edit/{id}',  [UserController::class, 'edit'])->name('admin.user.edit');
        Route::post('/update', [UserController::class, 'update'])->name('admin.user.update');
    });

	Route::group(['prefix' => 'feedback-question'], function ($router) {
        Route::get('/', [FeedbackQuestionController::class, 'index'])->name('admin.feedback_question.index');
        Route::get('/create', [FeedbackQuestionController::class, 'create'])->name('admin.feedback_question.create');
        Route::post('/store', [FeedbackQuestionController::class, 'store'])->name('admin.feedback_question.store');
        Route::post('/delete', [FeedbackQuestionController::class, 'delete'])->name('admin.feedback_question.delete');
        Route::get('/view/{id}',  [FeedbackQuestionController::class, 'create'])->name('admin.feedback_question.view');
        Route::get('/edit/{id}',  [FeedbackQuestionController::class, 'edit'])->name('admin.feedback_question.edit');
        Route::post('/update', [FeedbackQuestionController::class, 'update'])->name('admin.feedback_question.update');
    });
});


Route::group(['namespace' => 'AirportManager' , 'prefix' => 'airport-manager'], function ($router) {

    Route::get('/dashboard', [HeadOfDepartment::class, 'index'])->name('airport_manager.dashboard.index');
    Route::post('/dashboard-ajax', [HeadOfDepartment::class, 'dashboard_ajax'])->name('airport_manager.dashboard.ajax');
    Route::post('/dashboard-sales-brand', [HeadOfDepartment::class, 'ajax_sales_by_brand_city'])->name('airport_manager.dashboard.ajax_sales_by_brand_city');
    
    Route::post('/dashboard-sales-region', [HeadOfDepartment::class, 'ajax_sales_by_region'])->name('airport_manager.dashboard.ajax_sales_by_region');
    
    Route::post('/dashboard-purchase-behaviour', [HeadOfDepartment::class, 'ajax_purchase_behaviour'])->name('airport_manager.dashboard.ajax_purchase_behaviour');
    Route::post('/dashboard-sold-brand', [HeadOfDepartment::class, 'ajax_sold_brand'])->name('airport_manager.dashboard.ajax_sold_brand');
    Route::post('/dashboard-sales-by-location', [HeadOfDepartment::class, 'ajax_sales_by_location'])->name('airport_manager.dashboard.ajax_sales_by_location');
    
    Route::get('/dashboard-sales', [HeadOfDepartment::class, 'salesDashboard'])->name('airport_manager.dashboard.sales');
    Route::post('/dashboard-sales-post', [HeadOfDepartment::class, 'salesDashboardPost'])->name('airport_manager.dashboard.sales_post');


	Route::get('/logout', [HeadOfDepartment::class, 'logout'])->name('airport_manager.dashboard.logout');


    Route::group(['prefix' => 'pending-request'], function ($router) {
        Route::get('/', [PendingRequestController::class, 'index'])->name('airport_manager.pending_request.index');
        Route::post('/user_status_update', [PendingRequestController::class, 'user_status_update'])->name('airport_manager.pending_request.user_status_update');

    });

    Route::group(['prefix' => 'request-qty-approved'], function ($router) {
        Route::get('/', [RequestQtyController::class, 'index'])->name('airport_manager.requested_qty.index');
        Route::post('/qty_status_update', [RequestQtyController::class, 'qty_status_update'])->name('airport_manager.requested_qty.qty_status_update');
        Route::get('/search_filter_req_qty', [RequestQtyController::class, 'search_filter_req_qty'])->name('airport_manager.requested_qty.search_filter_req_qty');
        Route::post('/approved_update', [RequestQtyController::class, 'approved_update'])->name('airport_manager.requested_qty.approved_update');
    });

    Route::group(['prefix' => 'stock-qty-update'], function ($router) {
        Route::get('/', [StockQtyUpdateController::class, 'index'])->name('airport_manager.stock_qty_update.index');
        Route::post('/qty_status_update', [StockQtyUpdateController::class, 'qty_status_update'])->name('airport_manager.stock_qty_update.qty_status_update');
        Route::get('/search', [StockQtyUpdateController::class, 'search'])->name('airport_manager.stock_qty_update.search');        
    });
    

    Route::group(['prefix' => 'profile'], function ($router) {
		Route::get('/', [Settings::class, 'profile'])->name('airport_manager.profile.index');
        Route::get('/profile', [Settings::class, 'profile'])->name('airport_manager.profile.profile');
		Route::post('/profile-update', [Settings::class, 'profile_update'])->name('airport_manager.profile.profile_update');
	});
    
    Route::group(['prefix' => 'city-users'], function ($router) {
        Route::get('/', [CityUsersController::class, 'index'])->name('airport_manager.city_users.index');
        Route::get('/create', [CityUsersController::class, 'create'])->name('airport_manager.city_users.create');
        Route::post('/store', [CityUsersController::class, 'store'])->name('airport_manager.city_users.store');
        Route::post('/destroy', [CityUsersController::class, 'destroy'])->name('airport_manager.city_users.destroy');
        Route::get('/view/{id}',  [CityUsersController::class, 'view'])->name('airport_manager.city_users.view');
        Route::get('/edit/{id}',  [CityUsersController::class, 'edit'])->name('airport_manager.city_users.edit');
        Route::post('/update', [CityUsersController::class, 'update'])->name('airport_manager.city_users.update');
        Route::post('/user_status_update', [CityUsersController::class, 'user_status_update'])->name('airport_manager.city_users.user_status_update');
        Route::post('/status_filter', [CityUsersController::class, 'status_filter'])->name('airport_manager.city_users.status_filter');

        Route::post('/import', [CityUsersController::class, 'UsersImport'])->name('airport_manager.city_users.import');
        Route::post('/export', [CityUsersController::class, 'UsersExport'])->name('airport_manager.city_users.export');
    });
});
Route::group(['namespace' => 'Salesman' , 'prefix' => 'salesman'], function ($router) {

    Route::get('/dashboard', [DashboardSalesman::class, 'index'])->name('salesman.dashboard.index');
	Route::get('/logout', [DashboardSalesman::class, 'logout'])->name('salesman.dashboard.logout');

    Route::group(['prefix' => 'profile'], function ($router) {
		Route::get('/', [SalesmanProfile::class, 'profile'])->name('salesman.profile.index');
        Route::get('/profile', [SalesmanProfile::class, 'profile'])->name('salesman.profile.profile');
		Route::post('/profile-update', [SalesmanProfile::class, 'profile_update'])->name('salesman.profile.profile_update');
	});

    Route::group(['prefix' => 'sales-history'], function ($router) {
        Route::get('/', [SalesHistoryController::class, 'index'])->name('salesman.sales_history.index');
        Route::get('/search', [SalesHistoryController::class, 'search'])->name('salesman.sales_history.search');
    });
});