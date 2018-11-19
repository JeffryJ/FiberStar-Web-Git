<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//MAIN DATA
Route::get('main-data','ApiController@main_data');                      //MISSING: Main Web Data(Logo, Company name, address, phone, fax)
Route::get('social-media','ApiController@social_media');

//Landing Page Component(s)
Route::get('/landing-page','ApiController@landing_page_content');     //MISSING: CONTAINS WHO WE ARE & 4 BENEFITS
Route::get('/testimonials','ApiController@testimonials');               //Testimonials
Route::get('/landing-page-news','ApiController@landing_page_news');     //Home News

//News Component(s)
Route::get('/news-page','ApiController@news_page_content');
Route::get('/news','ApiController@news');                               //News items in News page
Route::get('/news/{id}','ApiController@news_content');                  //News details
Route::get('/newsletters','ApiController@newsletters');

//About Us Component(s)
Route::get('/about-us-page','ApiController@about_us_page_content');   //MISSING: CONTAINS VISION & MISSION, CORPORATE VALUES DESCRIPTION & IMAGE
Route::get('/milestones','ApiController@milestones');                   //Milestones timeline

//Services Component(s)
Route::get('/services','ApiController@services_page_content');          //Services

//Our Team Component(s)
Route::get('/our-team-concerns','ApiController@our_team_concerns');     //Concern Our Team
Route::get('/our-team-slider','ApiController@our_team_slider');         //Image Slider Our Team
Route::get('job-vacancies','ApiController@job_vacancies');              //Job Vacancy Boxes
Route::get('/job-vacancy/{id}','ApiController@job_vacancy_content');    //Job Req (Job vacancy details)

//Coverage Component(s)
Route::get('/coverage','ApiController@coverage_data');          //MISSING: Coverage Data(Map pins & api key)
Route::get('/fiberstar-coverage','ApiController@fiberstar_coverage');
Route::get('/coverage/cities','ApiController@get_cities');
Route::get('/coverage/kecamatans-of/{id}','ApiController@get_kecamatans');
Route::get('/coverage/kelurahans-of/{id}','ApiController@get_kelurahans');
Route::get('/coverage/roads-of/{id}','ApiController@get_roads');
Route::post('/coverage/coverage-request','ApiController@create_coverage_request');
//Contact Us Component(s)
Route::post('/mail','ContactMessageController@create_contact_us_email');//Contact Us Mailing API