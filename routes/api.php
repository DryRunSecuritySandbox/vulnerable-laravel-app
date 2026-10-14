<?php

Route::get('/events', 'EventController@index');
Route::post('/uploads', 'FileUploader');
Route::get('/file-details', 'GetFileDetails');

Route::get('/uploads/{id}', 'UploadsController@show');

