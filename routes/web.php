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

//User Routes
Route::get('/', function (){
    return redirect('/home');
});

Route::get('/home','WebController@HomePage');

Route::get('news', 'WebController@NewsPage');

Route::get('about','WebController@AboutUsPage');

Route::get('team', 'WebController@OurTeamPage');

Route::get('job/{id}', 'WebController@JobDetails');

Route::get('news/{id}', 'WebController@NewsDetails');

Route::get('services', 'WebController@ServicesPage');

Route::get('coverage','WebController@Coverage');
Route::get('coverage/my-coverage','WebController@my_coverage_form');
Route::get('coverage/fiberstar-coverage','WebController@show_fiberstar_coverage');
Route::get('test-coverage','WebController@TestCoverage');

Route::post('/testform',function(\Illuminate\Http\Request $req){
    return 'test';
});


/*
File Serving Route
*/
Route::get('storage/{path}', function($path){
    $path = storage_path('app/public/' . $path);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->where('path','.+');

//Auth::Routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
// passes some kind of token and role id
//register page needs to check some kind of token, else redirect to home.
Route::get('register/{email}/{token}', 'Auth\RegisterController@registration_form')->name('register');
Route::post('register-new-user', 'Auth\RegisterController@register_new_user');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


//Admin Routes
Route::middleware(['auth'])->prefix('/admin')->group(function () {
    Route::get('/',function(){
        return redirect('/admin/dashboard');
    });
    Route::get('/dashboard','Admin\DashboardController@dashboard');

    Route::middleware(['isSuperAdmin'])->group(function (){
        Route::prefix('/news')->group(function () {
            Route::get('/', 'Admin\NewsController@news_index');
            Route::get('/add', 'Admin\NewsController@add_news_form');
            Route::post('/add', 'Admin\NewsController@add_news');
            Route::get('/edit/{id}', 'Admin\NewsController@edit_news_form');
            Route::post('/edit', 'Admin\NewsController@edit_news');
            Route::post('/delete', 'Admin\NewsController@delete_news');
        });

        Route::prefix('/newsletter')->group(function () {
            Route::get('/', 'Admin\NewsletterController@newsletter_index');
            Route::get('/add', 'Admin\NewsletterController@add_newsletter_form');
            Route::post('/add', 'Admin\NewsletterController@add_newsletter');
            Route::get('/edit/{id}', 'Admin\NewsletterController@edit_newsletter_form');
            Route::post('/edit', 'Admin\NewsletterController@edit_newsletter');
            Route::post('/delete', 'Admin\NewsletterController@delete_newsletter');
        });

        Route::prefix('/milestones')->group(function () {
            Route::get('/', 'Admin\MilestonesController@milestones_index');
            Route::get('/add', 'Admin\MilestonesController@add_milestone_form');
            Route::post('/add', 'Admin\MilestonesController@add_milestone');
            Route::get('/edit/{id}', 'Admin\MilestonesController@edit_milestone_form');
            Route::post('/edit', 'Admin\MilestonesController@edit_milestone');
            Route::post('/delete', 'Admin\MilestonesController@delete_milestone');
        });

        Route::prefix('/testimonies')->group(function () {
            Route::get('/', 'Admin\TestimonyController@testimonies_index');
            Route::get('/add', 'Admin\TestimonyController@add_testimony_form');
            Route::post('/add', 'Admin\TestimonyController@add_testimony');
            Route::get('/edit/{id}', 'Admin\TestimonyController@edit_testimony_form');
            Route::post('/edit', 'Admin\TestimonyController@edit_testimony');
            Route::post('/delete', 'Admin\TestimonyController@delete_testimony');
        });

        Route::prefix('/services')->group(function () {
            Route::get('/', 'Admin\ServicesController@services_index');
            Route::get('/add', 'Admin\ServicesController@add_service_form');
            Route::post('/add', 'Admin\ServicesController@add_service');
            Route::get('/edit/{id}', 'Admin\ServicesController@edit_service_form');
            Route::post('/edit', 'Admin\ServicesController@edit_service');
            Route::post('/delete', 'Admin\ServicesController@delete_service');
        });

        Route::prefix('/landing-page')->group(function () {
            Route::get('/', 'Admin\LandingPageController@landing_page_index');
            Route::post('/update', 'Admin\LandingPageController@update_landing_page');
            Route::post('/delete-media', 'Admin\LandingPageController@delete_slider_content');
            Route::post('/add-media', 'Admin\LandingPageController@add_slider_content');
        });

        Route::prefix('/about-us')->group(function () {
            Route::get('/', 'Admin\AboutUsController@about_us_index');
            Route::post('/update', 'Admin\AboutUsController@update_about_us');
        });

        Route::prefix('/our-team')->group(function () {
            Route::get('/', 'Admin\OurTeamController@our_team_index');
            Route::post('/update', 'Admin\OurTeamController@update_our_team');
            Route::post('/delete-media', 'Admin\OurTeamController@delete_slider_content');
            Route::post('/add-media', 'Admin\OurTeamController@add_slider_content');
        });

        Route::prefix('/users')->group(function () {
            Route::get('/', 'Admin\UserController@users_index');

            Route::get('/edit/{id}', 'Admin\UserController@edit_user_modal');
            Route::post('/edit', 'Admin\UserController@edit_user');
            Route::post('/delete', 'Admin\UserController@delete_user');

            Route::get('/invite', 'Admin\UserController@invite_user_modal');
            Route::post('/invite', 'Admin\UserController@invite_user');
            Route::post('/delete-invite', 'Admin\UserController@delete_invite');
        });

        Route::prefix('/webconfig')->group(function () {
            Route::get('/', 'Admin\WebConfigController@webconfig_index');
            Route::post('/update', 'Admin\WebConfigController@update_webconfig');

            Route::prefix('/social-media')->group(function () {
                Route::get('add', 'Admin\WebconfigController@add_social_media_modal');
                Route::post('add', 'Admin\WebconfigController@add_social_media');
                Route::get('/edit/{id}', 'Admin\WebconfigController@edit_social_media_modal');
                Route::post('/edit', 'Admin\WebconfigController@edit_social_media');
                Route::post('/delete', 'Admin\WebConfigController@delete_social_media');
            });

            Route::prefix('/bing-api-key')->group(function () {
                Route::get('add', 'Admin\WebconfigController@add_bing_api_key_modal');
                Route::post('add', 'Admin\WebconfigController@add_bing_api_key');
                Route::get('/edit/{id}', 'Admin\WebconfigController@edit_bing_api_key_modal');
                Route::post('/edit', 'Admin\WebconfigController@edit_bing_api_key');
                Route::post('/delete', 'Admin\WebConfigController@delete_bing_api_key');
            });
        });
    });

    Route::middleware(['isHCDAdminOrHigher'])->group(function (){
        Route::prefix('/job-vacancies')->group(function (){
            Route::get('/','Admin\VacanciesController@vacancies_index');
            Route::get('/add','Admin\VacanciesController@add_vacancy_form');
            Route::post('/add','Admin\VacanciesController@add_vacancy');
            Route::get('/edit/{id}','Admin\VacanciesController@edit_vacancy_form');
            Route::post('/edit','Admin\VacanciesController@edit_vacancy');
            Route::post('/delete','Admin\VacanciesController@delete_vacancy');
        });
    });

    Route::middleware(['isDataManagementAdminOrHigher'])->group(function () {
        Route::prefix('/coverage')->group(function () {
            Route::get('/', 'Admin\CoverageController@coverage_index');
            Route::get('/add', 'Admin\CoverageController@add_coverage_form');
            Route::post('/add', 'Admin\CoverageController@add_coverage');
            Route::get('/edit/{id}', 'Admin\CoverageController@edit_coverage_form');
            Route::post('/edit', 'Admin\CoverageController@edit_coverage');
            Route::post('/delete', 'Admin\CoverageController@delete_coverage');
            Route::post('/import-area','Admin\CoverageController@import_area_information');
            Route::post('/import-coverage','Admin\CoverageController@import_fiberstar_coverage');
        });
    });

});