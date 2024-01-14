<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CSVController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UsersDetailController;
use App\Http\Controllers\CampaignTemplateController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\IntegrationServiceController;
use App\Models\CsvList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

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

Route::get('/',function () {
	return view('index');
});

Route::group(['middleware' => 'is_user'], function () {
	
	Route::get('/home', [HomeController::class, 'home']);

	Route::get('dashboard', function () {
		return view('user.dashboard');
	})->name('dashboard');

	Route::get('user-profile',[UserProfileController::class,'user_profile'])->name('user-profile');
	Route::post('update-user-profile',[UserProfileController::class,'update_user_profile'])->name('update-user-profile');
	// Route::get('lists',[CSVController::class,'user_csv_lists'])->name('lists');

	Route::get('lists',[CSVController::class,'user_csv_lists'])->name('lists');

	Route::get('field', function () {
		return view('field');
	})->name('field');
	Route::post('multifield',[CSVController::class,'multifield'])->name('multifield');

	Route::post('select-list',[CSVController::class,'select_list']);
	Route::post('user-csv-lists',[CSVController::class,'user_csv_lists']);
	Route::post('/lead-info/{token}',[LeadController::class,'lead_info']);

	Route::post('csv-file',[CSVController::class,'csv_file'])->name('csv-file');
	Route::post('/upload-csv',[CSVController::class,'upload_csv_in_existed_list'])->name('add-more');
	Route::post('custom-add',[CSVController::class,'custom_add'])->name('custom-add');
	Route::post('/list-lead-manaully-user-add',[LeadController::class,'list_lead_manaully_user_add'])->name('list-lead-manaully-user-add');
	Route::post('custom-list',[CSVController::class,'custom_list'])->name('custom-list');

	Route::get('leads',[LeadController::class,'leads'])->name('leads');
	Route::post('delete-list/{token}',[CSVController::class,'delete_list'])->name('delete-list');
	Route::post('edit-list/{token}',[CSVController::class,'edit_list'])->name('edit-list');
	Route::post('update-list',[CSVController::class,'update_list'])->name('update-list');
	Route::post('delete-lead/{token}',[LeadController::class,'delete_lead'])->name('delete-lead');
	Route::post('edit-lead/{token}',[LeadController::class,'edit_lead'])->name('edit-lead');
	Route::post('update-lead',[LeadController::class,'update_lead'])->name('update-lead');
	Route::get('list-leads/{token?}',[LeadController::class,'list_leads'])->name('list-leads');
	Route::get('process-lists',[CSVController::class,'processing_csv_lists'])->name('processing-csv-lists');
	Route::post('reupload-list',[CSVController::class,'reupload_list'])->name('reupload-list');

	Route::get('campaign-templates',[CampaignTemplateController::class,'campaign_templates'])->name('campaign-templates');
	Route::get('create-template',[CampaignTemplateController::class,'create_template'])->name('create-template');
	Route::post('save-campaign-template',[CampaignTemplateController::class,'save_campaign_template'])->name('save-campaign-template');
	Route::post('delete-campaign-template',[CampaignTemplateController::class,'delete_campaign_template'])->name('delete-campaign-template');
	Route::get('/edit-campaign-template/{token}',[CampaignTemplateController::class,'edit_campaign_template'])->name('edit-campaign-template');
	Route::post('/update-campaign-template',[CampaignTemplateController::class,'update_campaign_template'])->name('update-campaign-template');
	Route::get('/template-view/{token}',[CampaignTemplateController::class,'template_view'])->name('template-view');

	Route::get('/integration-credentials',[CampaignController::class,'integration_credentials'])->name('integration-credentials');
	Route::post('smpt-service',[CampaignController::class,'smpt_service'])->name('smpt-service');
	Route::post('find-integration-service',[CampaignController::class,'find_integration_service'])->name('find-integration-service');
	Route::post('create-integration-credential',[CampaignController::class,'create_integration_credential'])->name('create-integration-credential');
	Route::post('delete-integration-credential',[CampaignController::class,'delete_integration_credential'])->name('delete-integration-credential');
	Route::post('edit-integration-credential',[CampaignController::class,'edit_integration_credential'])->name('edit-integration-credential');
	Route::post('update-integration-credential',[CampaignController::class,'update_integration_credential'])->name('update-integration-credential');

	Route::get('/campaigns',function () {
		return view('user.campaign');
	})->name('campaigns');
	Route::post('/all-campaigns',[CampaignController::class,'all_campaigns'])->name('all-campaigns');

	Route::post('/create-campaign',[CampaignController::class,'create_campaign'])->name('create-campaign');
	Route::post('/save-campaign',[CampaignController::class,'save_campaign'])->name('save-campaign');
	Route::post('/delete-campaign/{token}',[CampaignController::class,'delete_campaign'])->name('delete-campaign');
	Route::post('/edit-campaign/{token}',[CampaignController::class,'edit_campaign'])->name('edit-campaign');
	Route::post('/update-campaign',[CampaignController::class,'update_campaign'])->name('update-campaign');

	Route::post('/change-active/{token}',[CampaignController::class,'change_active'])->name('change-active');
	Route::post('/duplicate-campaign/{token}',[CampaignController::class,'duplicate_campaign'])->name('duplicate-campaign');
	Route::post('campaign-preview/{listToken}/{templateToken}/{credentialToken}',[CampaignController::class,'campaign_preview'])->name('campaign-preview');

	Route::get('subscriptions',[SubscriptionController::class,'subscriptions'])->name('subscriptions');
	Route::post('/subscribe-package',[SubscriptionController::class,'subscribe_package'])->name('subscribe-package');
	
	Route::get('billing', function () {
		return view('user.billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('user.profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('user.rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('user.tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('user.virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('user.static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('user.static-sign-up');
	})->name('sign-up');

    // Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});

Route::get('/logout', [SessionsController::class, 'destroy']);


Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');
Route::get('/register', function () {
    return view('session/register');
})->name('register');


Route::group(['middleware' => 'is_admin'], function () {
Route::get('/admin',function () {
	return view('admin.dashboard');
});

Route::get('/packages-info',[SubscriptionController::class,'package_info']);

Route::post('/create-package',[SubscriptionController::class,'create_package'])->name('create-package');
Route::post('/edit-package',[SubscriptionController::class,'edit_package'])->name('edit-package');
Route::post('/update-package',[SubscriptionController::class,'update_package'])->name('update-package');
Route::post('/delete-package',[SubscriptionController::class,'delete_package'])->name('delete-package');

Route::post('/user-bann',[UsersDetailController::class,'user_bann'])->name('user-bann');
Route::post('/user-unbann',[UsersDetailController::class,'user_unbann'])->name('user-unbann');

Route::get('/integration-services',[IntegrationServiceController::class,'integration_services'])->name('integration-services');

Route::get('/users',[UsersDetailController::class,'users_info'])->name('users');

// Route::get('/logout', [SessionsController::class, 'destroy']);
});