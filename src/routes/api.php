<?php

Route::group(['middleware' => ['jwt.auth', 'jwt.refresh']], function () {

    /*
    |----------------------------------
    | ARTICLES
    |----------------------------------
    */
    Route::get('api/v1/cms/article/{lang?}',                               ['as' => 'cmsArticle',                       'uses' => 'Syscover\Cms\Controllers\ArticleController@index']);
    Route::get('api/v1/cms/article/{id}/{lang}',                           ['as' => 'showCmsArticle',                   'uses' => 'Syscover\Cms\Controllers\ArticleController@show']);
    Route::post('api/v1/cms/article/search',                               ['as' => 'searchCmsArticle',                 'uses' => 'Syscover\Cms\Controllers\ArticleController@search']);
    Route::post('api/v1/cms/article',                                      ['as' => 'storeCmsArticle',                  'uses' => 'Syscover\Cms\Controllers\ArticleController@store']);
    Route::put('api/v1/cms/article/{id}/{lang}',                           ['as' => 'updateCmsArticle',                 'uses' => 'Syscover\Cms\Controllers\ArticleController@update']);
    Route::delete('api/v1/cms/article/{id}/{lang?}',                       ['as' => 'destroyCmsArticle',                'uses' => 'Syscover\Cms\Controllers\ArticleController@destroy']);

    /*
    |----------------------------------
    | CATEGORIES
    |----------------------------------
    */
    Route::get('api/v1/cms/category/{lang?}',                               ['as' => 'cmsCategory',                     'uses' => 'Syscover\Cms\Controllers\CategoryController@index']);
    Route::get('api/v1/cms/category/{id}/{lang}',                           ['as' => 'showCmsCategory',                 'uses' => 'Syscover\Cms\Controllers\CategoryController@show']);
    Route::post('api/v1/cms/category/search',                               ['as' => 'searchCmsCategory',               'uses' => 'Syscover\Cms\Controllers\CategoryController@search']);
    Route::post('api/v1/cms/category',                                      ['as' => 'storeCmsCategory',                'uses' => 'Syscover\Cms\Controllers\CategoryController@store']);
    Route::put('api/v1/cms/category/{id}/{lang}',                           ['as' => 'updateCmsCategory',               'uses' => 'Syscover\Cms\Controllers\CategoryController@update']);
    Route::delete('api/v1/cms/category/{id}/{lang?}',                       ['as' => 'destroyCmsCategory',              'uses' => 'Syscover\Cms\Controllers\CategoryController@destroy']);

    /*
    |----------------------------------
    | SECTIONS
    |----------------------------------
    */
    Route::get('api/v1/cms/section',                                        ['as' => 'cmsSection',                      'uses' => 'Syscover\Cms\Controllers\SectionController@index']);
    Route::get('api/v1/cms/section/{id}',                                   ['as' => 'showCmsSection',                  'uses' => 'Syscover\Cms\Controllers\SectionController@show']);
    Route::post('api/v1/cms/section',                                       ['as' => 'storeCmsSection',                 'uses' => 'Syscover\Cms\Controllers\SectionController@store']);
    Route::post('api/v1/cms/section/search',                                ['as' => 'searchCmsSection',                'uses' => 'Syscover\Cms\Controllers\SectionController@search']);
    Route::put('api/v1/cms/section/{id}',                                   ['as' => 'updateCmsSection',                'uses' => 'Syscover\Cms\Controllers\SectionController@update']);
    Route::delete('api/v1/cms/section/{id}',                                ['as' => 'destroyCmsSection',               'uses' => 'Syscover\Cms\Controllers\SectionController@destroy']);

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