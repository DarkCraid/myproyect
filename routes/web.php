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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bienvenida',function(){

	return 'Bienvenidos al curso de laravel';
});

Route::get('/pollo/{guarni}/{bebida?}',function($guarni,$bebida="coca"){
	return 'Comes pollo con '.$guarni.' y tomas '.$bebida;
});

Route::get('/notificacion','prueba82@notificacion');


Route::get('/saludar',function(){
	return view('saludar');


});
Route::post('/save','prueba82@save');

Route::get('/formulario','personas@index');
Route::post('/save','personas@store');  // php artisan make:controller Personas --personas
Route::get('/todos','personas@index');
Route::get('/buscar','personas@buscar');
Route::post('/eliminar','personas@eliminar');
Route::get('/modificar/{id}','personas@modificar');
Route::post('/actualizar','personas@actualizar');