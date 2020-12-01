<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
	public function index() {
		return Usuario::all();
	}

	public function show(Request $request) {
		$usuario = Usuario::find($request["id"]);
		if (is_null($usuario)) return response() -> json(null, 204);
		return ($usuario);
	}
	
	public function store(Request $request){
		return response() -> json(
			Usuario::create($request->all()),
			201
		);
	}

	public static function IsEmailOnDB(String $email) {
		$user = Usuario::where('email', $email)->first();
		if (is_null($user)) return 0;
		return $user->id;
	}
}
