<?php 


/*SOCIALITE AUTHENTICATION ROUTE SECTION*/
Route::group(['prefix'=>'admin','middleware' => ['web']], function () {

	Route::resource('generate', 'MspPack\DDSGenerate\Http\GeneratorController');
	
	Route::delete('module/{slug}/{id}', 'MspPack\DDSGenerate\Http\ModuleController@destroy');
	Route::get('module/{slug}/{id}/edit', 'MspPack\DDSGenerate\Http\ModuleController@edit');
	Route::patch('module/{slug}/{id}', 'MspPack\DDSGenerate\Http\ModuleController@update');
	
	Route::resource('module/{slug}', 'MspPack\DDSGenerate\Http\ModuleController');
});
