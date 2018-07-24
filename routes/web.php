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

Route::group(['middleware' => ['api', 'auth']], function () {
//Route::group(['middleware' => ['api', 'auth', 'verify.ip']], function () {
    // 前台
    Route::any('/', 'IndexController@index')->name('/');
    Route::any('/welcome', 'IndexController@welcome')->name('welcome');
    // 活动
    Route::any('/activity', 'ActivityController@index')->name('activity');
    Route::any('/activity_add', 'ActivityController@add')->name('activity_add');
    Route::any('/activity_del', 'ActivityController@del')->name('activity_del');
    Route::any('/activity_edit', 'ActivityController@edit')->name('activity_edit');
    Route::any('/activity_show', 'ActivityController@show')->name('activity_show');
    Route::any('/activity_search', 'ActivityController@search')->name('activity_search');
    Route::any('/activity_move', 'ActivityController@sotr')->name('activity_move');
    // 弹窗活动
    Route::any('/recommend', 'RecommendController@index')->name('recommend');
    Route::any('/recommend_add', 'RecommendController@add')->name('recommend_add');
    Route::any('/recommend_del', 'RecommendController@del')->name('recommend_del');
    Route::any('/recommend_edit', 'RecommendController@edit')->name('recommend_edit');
    Route::any('/recommend_move', 'RecommendController@sort')->name('recommend_move');
    // 资讯
    Route::any('/newsinformation', 'NewsInformationController@index')->name('newsinformation');
    Route::any('/newsinformation_add', 'NewsInformationController@add')->name('newsinformation_add');
    Route::any('/newsinformation_del', 'NewsInformationController@del')->name('newsinformation_del');
    Route::any('/newsinformation_edit', 'NewsInformationController@edit')->name('newsinformation_edit');
    Route::any('/newsinformation_show', 'NewsInformationController@show')->name('newsinformation_show');
    Route::any('/newsinformation_search', 'NewsInformationController@search')->name('newsinformation_search');
    // 公告
    Route::any('/bulletin', 'BulletinController@index')->name('bulletin');
    Route::any('/bulletin_add', 'BulletinController@add')->name('bulletin_add');
    Route::any('/bulletin_del', 'BulletinController@del')->name('bulletin_del');
    Route::any('/bulletin_edit', 'BulletinController@edit')->name('bulletin_edit');
    Route::any('/bulletin_show', 'BulletinController@show')->name('bulletin_show');
    Route::any('/bulletin_search', 'BulletinController@search')->name('bulletin_search');
    // 广告
    Route::any('/advertising', 'AdvertisingController@index')->name('advertising');
    Route::any('/advertising_add', 'AdvertisingController@add')->name('advertising_add');
    Route::any('/advertising_del', 'AdvertisingController@del')->name('advertising_del');
    Route::any('/advertising_edit', 'AdvertisingController@edit')->name('advertising_edit');
    // 轮播图管理
    Route::any('/rotation', 'RotationController@index')->name('rotation');
    Route::any('/rotation_add', 'RotationController@add')->name('rotation_add');
    Route::any('/rotation_del', 'RotationController@del')->name('rotation_del');
    Route::any('/rotation_edit', 'RotationController@edit')->name('rotation_edit');
    Route::any('/rotation_move', 'RotationController@sort')->name('rotation_move');
    // 赛事推荐
    Route::any('/match', 'MatchController@index')->name('match');
    Route::any('/match_add', 'MatchController@add')->name('match_add');
    Route::any('/match_del', 'MatchController@del')->name('match_del');
    Route::any('/match_edit', 'MatchController@edit')->name('match_edit');
    Route::any('/match_is_top', 'MatchController@is_top')->name('match_is_top');
    Route::any('/match_move', 'MatchController@move')->name('match_move');
    // ip
    Route::any('/ip_info', 'IpController@index')->name('ip_info');
    Route::any('/ip_add', 'IpController@add')->name('ip_add');
    Route::any('/ip_del', 'IpController@del')->name('ip_del');
    Route::any('/ip_edit', 'IpController@edit')->name('ip_edit');
    // 管理员列表
    Route::any('/users', 'UsersController@index')->name('users');
    Route::any('/users_add', 'UsersController@add')->name('users_add');
    Route::any('/users_del', 'UsersController@del')->name('users_del');
    Route::any('/users_edit', 'UsersController@edit')->name('users_edit');
    Route::any('/users_enable', 'UsersController@enable')->name('users_enable');
    Route::any('/loginout', 'UsersController@loginout')->name('loginout');
    // 角色管理
    Route::any('/role', 'RoleController@index')->name('role');
    Route::any('/role_add', 'RoleController@add')->name('role_add');
    Route::any('/role_edit', 'RoleController@edit')->name('role_edit');
    Route::any('/role_del', 'RoleController@del')->name('role_del');
    // 权限管理
    Route::any('/power', 'PowerController@index')->name('power');
    // 公司管理
    Route::any('/company', 'CompanyController@company')->name('company');
    Route::any('/company_add', 'CompanyController@add')->name('company_add');
    Route::any('/company_del', 'CompanyController@del')->name('company_del');
    Route::any('/company_edit', 'CompanyController@edit')->name('company_edit');
    Route::any('/company_search', 'CompanyController@search')->name('company_search');
    // 域名管理
    Route::any('/domain', 'DomainController@domain')->name('domain');
    Route::any('/domain_add', 'DomainController@domain_add')->name('domain_add');
    Route::any('/domain_del', 'DomainController@domain_del')->name('domain_del');
    Route::any('/domain_change', 'DomainController@domain_change')->name('domain_change');
    Route::any('/domain_edit', 'DomainController@domain_edit')->name('domain_edit');
});
Auth::routes();

Route::get('/home', 'IndexController@index')->name('home');
