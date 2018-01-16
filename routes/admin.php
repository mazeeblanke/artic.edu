<?php

Route::module('pages');

Route::group(['prefix' => 'landing'], function () {
    Route::name('landing.home')->get('home', 'PageController@home');
    Route::name('landing.exhibitions')->get('exhibitions', 'PageController@exhibitions');
    Route::name('landing.art')->get('art', 'PageController@art');
    Route::name('landing.visit')->get('visit', 'PageController@visit');
});

Route::group(['prefix' => 'whatson'], function () {
    Route::module('events');
    Route::name('events.augment')->get('events/augment/{datahub_id}', 'EventController@augment');

    Route::module('exhibitions');
    Route::module('articles');
    Route::module('artists');
    Route::module('artworks');
    Route::module('selections');
    Route::module('shopItems');
});

Route::group(['prefix' => 'general'], function () {
    Route::module('hours');
    Route::module('closures');
    Route::module('categories');
    Route::module('siteTags');
    Route::module('segments');
    Route::module('sponsors');
    Route::module('questions');
    Route::module('admissions');
    Route::module('locations');
    Route::module('feeAges');
    Route::module('feeCategories');
    Route::name('general.fees')->get('/fees', 'FeeController@index');
    Route::name('general.fees.update')->post('/fees', 'FeeController@update');
});

Route::get('/', function () {
    return redirect()->route('admin.featured.homepage');
});
