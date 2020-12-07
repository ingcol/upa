
<?php
/*
use App\Taxi;
use App\Estado;
use App\Empresa;
use App\Domicilio;
use App\Emergencia;
use App\Publicidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\Taxi as TaxiResource;
use App\Http\Resources\Estado as EstadoResource;
use App\Http\Resources\Empresa as EmpresaResource;
use App\Http\Resources\Domicilio as DomicilioResource;
use App\Http\Resources\Emergencia as EmergenciaResource;
use App\Http\Resources\Publicidad as PublicidadResource;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/estados', function () {
    return EstadoResource::collection(Estado::get());
});

Route::middleware('auth:api')->get('/publicidadintermedia/{ciudad}', function ($ciudad){
    return PublicidadResource::collection(Publicidad::where('categoria','=', 'intermedia')->Ciudad($ciudad)->get());
});

Route::middleware('auth:api')->get('/publicidadbanner/{ciudad}', function ($ciudad){
    return PublicidadResource::collection(Publicidad::where('categoria','=', 'banner')->Ciudad($ciudad)->get());
});

Route::middleware('auth:api')->get('/publicidadinicial', function (){
    return PublicidadResource::collection(Publicidad::where('categoria','=', 'inicial')->get());
});

Route::middleware('auth:api')->get('/publicidadinicialradio', function (){
    return PublicidadResource::collection(Publicidad::where('categoria','=', 'radio')->get());
});


Route::middleware('auth:api')->get('/publicidad/{ciudad}/{categoria}', function ($ciudad,$categoria){
    return PublicidadResource::collection(Publicidad::where('categoria','=', $categoria)->Ciudad($ciudad)->get());
});

Route::middleware('auth:api')->get('empresas/{ciudad}', function ($ciudad) {
    return EmpresaResource::collection(Empresa::where('ciudad_id','=', $ciudad)->get());
});

Route::middleware('auth:api')->get('emergencia/{ciudad}', function ($ciudad) {
    return EmergenciaResource::collection(Emergencia::where('ciudad_id','=', $ciudad)->orderBy('orden')->get());
});


Route::middleware('auth:api')->get('taxis/{ciudad}', function ($ciudad) {
    return TaxiResource::collection(Taxi::where('ciudad_id','=', $ciudad)->orderBy('orden')->get());
});


Route::middleware('auth:api')->post('registrarempresa', 'EmpresaController@store');

Route::middleware('auth:api')->post('enviarsugerencia', 'EmpresaController@sugerencia');


Route::middleware('auth:api')->get('categorias/{ciudad}', 'CategoriaController@api');

Route::middleware('auth:api')->get('profesiones/{ciudad}', 'ProfesionController@api');

Route::middleware('auth:api')->get('domicilios/{ciudad}', function ($ciudad) {
    return DomicilioResource::collection(Domicilio::where('ciudad_id','=', $ciudad)->get());
});
*/

