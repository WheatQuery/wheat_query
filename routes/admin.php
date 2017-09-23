<?php

Route::get("test", 'admin\TestController@test');
Route::post("/get", 'admin\TestController@get_wheat');
