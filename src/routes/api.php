<?php

Route::group(['middleware' => ['jwt.auth', 'jwt.refresh']], function () {

    /*
    |----------------------------------
    | SECTIONS
    |----------------------------------
    */
    Route::get('api/v1/cms/section',                                         ['as' => 'cmsSection',                     'uses' => 'Syscover\Cms\Controllers\SectionController@index']);
    Route::get('api/v1/cms/section/{id}',                                    ['as' => 'showCmsSection',                 'uses' => 'Syscover\Cms\Controllers\SectionController@show']);
    Route::post('api/v1/cms/section',                                        ['as' => 'storeCmsSection',                'uses' => 'Syscover\Cms\Controllers\SectionController@store']);
    Route::post('api/v1/cms/section/search',                                 ['as' => 'searchCmsSection',               'uses' => 'Syscover\Cms\Controllers\SectionController@search']);
    Route::put('api/v1/cms/section/{id}',                                    ['as' => 'updateCmsSection',               'uses' => 'Syscover\Cms\Controllers\SectionController@update']);
    Route::delete('api/v1/cms/section/{id}',                                 ['as' => 'destroyCmsSection',              'uses' => 'Syscover\Cms\Controllers\SectionController@destroy']);

    /*
    |----------------------------------
    | ARTICLE FAMILIES
    |----------------------------------
    */
    Route::get('api/v1/cms/family',                                         ['as' => 'cmsFamily',                       'uses' => 'Syscover\Cms\Controllers\FamilyController@index']);
    Route::get('api/v1/cms/family/{id}',                                    ['as' => 'showCmsFamily',                   'uses' => 'Syscover\Cms\Controllers\FamilyController@show']);
    Route::post('api/v1/cms/family',                                        ['as' => 'storeCmsFamily',                  'uses' => 'Syscover\Cms\Controllers\FamilyController@store']);
    Route::post('api/v1/cms/family/search',                                 ['as' => 'searchCmsFamily',                 'uses' => 'Syscover\Cms\Controllers\FamilyController@search']);
    Route::put('api/v1/cms/family/{id}',                                    ['as' => 'updateCmsFamily',                 'uses' => 'Syscover\Cms\Controllers\FamilyController@update']);
    Route::delete('api/v1/cms/family/{id}',                                 ['as' => 'destroyCmsFamily',                'uses' => 'Syscover\Cms\Controllers\FamilyController@destroy']);
});