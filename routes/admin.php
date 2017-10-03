<?php

Route::post("/get", 'admin\AdminController@get_wheat');
Route::get("/download", 'admin\AdminController@download');
Route::post("/import", 'admin\AdminController@import');
Route::get("/read_excel", 'admin\AdminController@read_excel');
Route::post("/detail", 'admin\AdminController@get_detail');
Route::post("/search", 'admin\AdminController@search');
Route::post("/batch_delete", 'admin\AdminController@batch_delete');


Route::get("/test", 'admin\AdminController@test');
