<?php

use Core\Router as Route;
use App\Controller\SliderController;

Route::get('about/{name}',function (){
    echo "home isledi";
});
Route::get('slider/{id}', [SliderController::class, 'home']);


Route::get('user/{name}/{surname}', ['ContactController', 'storeData']);
Route::get('slider/{id}/tofiq/ruslan', ['SliderController', 'index']);
Route::get('/',['HomeController','index']);
Route::get('/about/{name}',['AboutController','index']);
Route::post('contact/{id}', ['ContactController', 'storeData']);
