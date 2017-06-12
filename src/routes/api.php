<?php

Route::group(['middleware' => ['jwt.auth', 'jwt.refresh']], function () {

    /*
    |----------------------------------
    | USERS
    |----------------------------------
    */
    Route::get('api/v1/admin/user',                                         ['as' => 'adminUser',                           'uses' => 'Syscover\Admin\Controllers\UserController@index']);
    Route::get('api/v1/admin/user/{id}',                                    ['as' => 'showAdminUser',                       'uses' => 'Syscover\Admin\Controllers\UserController@show']);
    Route::post('api/v1/admin/user',                                        ['as' => 'storeAdminUser',                      'uses' => 'Syscover\Admin\Controllers\UserController@store']);
    Route::post('api/v1/admin/user/search',                                 ['as' => 'searchAdminUser',                     'uses' => 'Syscover\Admin\Controllers\UserController@search']);
    Route::put('api/v1/admin/user/{id}',                                    ['as' => 'updateAdminUser',                     'uses' => 'Syscover\Admin\Controllers\UserController@update']);
    Route::delete('api/v1/admin/user/{id}',                                 ['as' => 'destroyAdminUser',                    'uses' => 'Syscover\Admin\Controllers\UserController@destroy']);

    /*
    |----------------------------------
    | LANGS
    |----------------------------------
    */
    Route::get('api/v1/admin/lang',                                         ['as' => 'adminLang',                           'uses' => 'Syscover\Admin\Controllers\LangController@index']);
    Route::get('api/v1/admin/lang/{id}',                                    ['as' => 'showAdminLang',                       'uses' => 'Syscover\Admin\Controllers\LangController@show']);
    Route::post('api/v1/admin/lang',                                        ['as' => 'storeAdminLang',                      'uses' => 'Syscover\Admin\Controllers\LangController@store']);
    Route::post('api/v1/admin/lang/search',                                 ['as' => 'searchAdminLang',                     'uses' => 'Syscover\Admin\Controllers\LangController@search']);
    Route::put('api/v1/admin/lang/{id}',                                    ['as' => 'updateAdminLang',                     'uses' => 'Syscover\Admin\Controllers\LangController@update']);
    Route::delete('api/v1/admin/lang/{id}',                                 ['as' => 'destroyAdminLang',                    'uses' => 'Syscover\Admin\Controllers\LangController@destroy']);

    /*
    |----------------------------------
    | COUNTRIES
    |----------------------------------
    */
    Route::get('api/v1/admin/country/{lang?}',                              ['as' => 'adminCountry',                         'uses' => 'Syscover\Admin\Controllers\CountryController@index']);
    Route::get('api/v1/admin/country/{id}/{lang}',                          ['as' => 'showAdminCountry',                     'uses' => 'Syscover\Admin\Controllers\CountryController@show']);
    Route::post('api/v1/admin/country/search',                              ['as' => 'searchAdminCountry',                   'uses' => 'Syscover\Admin\Controllers\CountryController@search']);
    Route::post('api/v1/admin/country',                                     ['as' => 'storeAdminCountry',                    'uses' => 'Syscover\Admin\Controllers\CountryController@store']);
    Route::put('api/v1/admin/country/{id}/{lang}',                          ['as' => 'updateAdminCountry',                   'uses' => 'Syscover\Admin\Controllers\CountryController@update']);
    Route::delete('api/v1/admin/country/{id}/{lang?}',                      ['as' => 'destroyAdminCountry',                  'uses' => 'Syscover\Admin\Controllers\CountryController@destroy']);
});

/*
|----------------------------------
| ATTACHMENTS
|----------------------------------
*/
Route::post('api/v1/admin/attachment-upload',                           ['as' => 'adminAttachmentUpload',               'uses' => 'Syscover\Admin\Controllers\AttachmentController@index']);
Route::post('api/v1/admin/attachment-upload/crop',                      ['as' => 'cropAdminAttachmentUpload',           'uses' => 'Syscover\Admin\Controllers\AttachmentController@crop']);
Route::post('api/v1/admin/attachment-upload/delete',                    ['as' => 'destroyAdminAttachmentUpload',        'uses' => 'Syscover\Admin\Controllers\AttachmentController@destroy']);