<?php
namespace App\Helpers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class Helper {


	public static function uploadFilefoto($nombre, $ruta) {

		$file = request()->file($nombre);

		$extension = $file->getClientOriginalExtension();

	//	$img->fit(600, 360);

		$image = Image::make($file)->fit(1024,576, function ($constraint) {$constraint->upsize();});

	//	$image = Image::make($file)->widen(1275, function ($constraint) {$constraint->upsize();});

		$resource = $image->stream()->detach();

	//	$nombrefinalfoto = Storage::disk('s3')->putFile('empresas', request()->file($nombre), 'public');


	
		$nombrefinalfoto = \Carbon\Carbon::now()->format('Y-m-d H-i-s').Auth::user()->id.'.'.$extension;		

		Storage::disk('s3')->put($ruta.'/'.$nombrefinalfoto, $resource, 'public');		

		return $nombrefinalfoto;
	}


	public static function uploadFileLogo($nombre, $ruta) {

		$file = request()->file($nombre);

		$extension = $file->getClientOriginalExtension();

	//	$img->fit(600, 360);

		$image = Image::make($file)->fit(200,200, function ($constraint) {$constraint->upsize();});

	//	$image = Image::make($file)->widen(1275, function ($constraint) {$constraint->upsize();});

		$resource = $image->stream()->detach();

	//	$nombrefinalfoto = Storage::disk('s3')->putFile('empresas', request()->file($nombre), 'public');


	
		$nombrefinalfoto = \Carbon\Carbon::now()->format('Y-m-d H-i-s').Auth::user()->id.'.'.$extension;		

		Storage::disk('s3')->put($ruta.'/'.$nombrefinalfoto, $resource, 'public');		

		return $nombrefinalfoto;
	}
}