<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;


class UsuarioController extends Controller
{
	public function index() {
		return Usuario::all();
	}

	public function show(int $id) {
		$usuario = Usuario::find($id);
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
		// ONE LINE HERO
		// foreach(Usuario::all() as $user) if (json_decode($user)->email === $email) return json_decode($user)->id;

		$usuarios = Usuario::all();
		foreach($usuarios as $user) {
			$data = json_decode($user);
			if ($data->email === $email) return $data->id;
		}
		return 0;
	}
}
