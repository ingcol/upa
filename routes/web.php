<?php

use Illuminate\Support\Facades\Route;

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
	return redirect()->route('login');
});
//Web
Route::get('/','WebController@index')->name('web.index');
Route::get('contacto','ContactenosController@index')->name('contacto.index');
Route::get('nosotros','NosotrosController@index')->name('nosotros.index');
Route::get('/empresa/{id}','WebController@detalleEmpresa');


Auth::routes();


//Api vue 
Route::group(['prefix' => 'api'], function(){

	//Web

	Route::get('filtroEmpresa','FiltroEmpresaController@datos');
	Route::get('ciudades','FiltroEmpresaController@ciudad');
	Route::get('subCategoriaFiltro','FiltroEmpresaController@subCategoriaFiltro');
	Route::post('contacto','ContactenosController@enviar');
	Route::get('nosotros','NosotrosController@datos');
	Route::get('/verDetalleempresa/{id}','WebController@verDetalleempresa');

	Route::get('/footer','FooterController@index');

	//end web

	//Admin

	Route::get('promocion', 'PromocionController@datos');
	Route::post('guardarPromocion', 'PromocionController@guardarPromocion');
	Route::put('actualizarPromocion/{id}', 'PromocionController@actualizarPromocion');

	Route::get('nosotrosAdmin', 'NosotrosAdminController@datos');
	Route::put('nosotrosAdmin', 'NosotrosAdminController@actualizar');
	Route::get('publicidad', 'PublicidadController@datos');
	Route::post('guardarPublicidad', 'PublicidadController@guardarPublicidad');
	Route::put('actualizarPublicidad/{id}', 'PublicidadController@actualizarPublicidad');
	Route::get('ciudadPublicidad', 'PublicidadController@ciudad');
	Route::delete('eliminarPublicidad/{id}', 'PublicidadController@eliminarPublicidad');
	Route::get('empresas', 'EmpresaController@datos');
	Route::get('listadoEmpresas', 'EmpresaController@listadoEmpresas');
	Route::get('categoria', 'CategoriaAdminController@datos');
	Route::get('subcategoria', 'SubCategoriaController@datos');


});

//Route::view('/home', 'web/index');

Route::resource('empresas', 'EmpresaController');

Route::resource('profesionales', 'ProfesionalController', ['except' => 'show','edit','index']);

Route::resource('galeria', 'GaleriaController')->except(['show','edit','create','index']);

Route::post('/upload', 'GaleriaController@upload')->name('upload');
Route::get('promocion', 'PromocionController@index')->name('promocion.index');
Route::get('nosotrosAdmin', 'NosotrosAdminController@index')->name('nosotrosAdmin.index');
Route::get('publicidad', 'PublicidadController@index')->name('publicidad.index');

Route::resource('categoria', 'CategoriaAdminController')->except(['show','edit','create']);
Route::resource('subcategoria', 'SubCategoriaController')->except(['show','edit','create']);
