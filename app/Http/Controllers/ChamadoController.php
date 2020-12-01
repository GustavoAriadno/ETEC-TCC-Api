<?php

namespace App\Http\Controllers;

use App\Chamado;
use Illuminate\Http\Request;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EquipamentoController;


class ChamadoController extends Controller
{
	public function index() {
		return Chamado::all();
	}

	public function show(Request $request) {
		$chamado = Chamado::find($request["id"]);
		if (is_null($chamado)) return response() -> json(null, 204);
		return ($chamado);
	}

	public function store(Request $request) {
		// CHECK if "problem", "email" or "sigla" exists
		if ($request["sigla"] == NULL ||
			$request["email"] == NULL ||
			$request["problema"] == NULL) return response() -> json(["status" => -1], 200);
		
		// CHECK if the user EMAIL is in the database and GET id from user
		$request["idUsuario"] = UsuarioController::IsEmailOnDB($request["email"]);
		if (!$request["idUsuario"]) return response() -> json(["status" => -2], 200);

		// GET idEquipamento and idLocal from database
		list($request["idEquipamento"], $request["idLocal"]) = EquipamentoController::isSiglaOnDB($request["sigla"]);
		if (!$request["idEquipamento"] || !$request["idLocal"]) return response() -> json(["status" => -3], 200);

		// DATE of support request
		$request["dataAbertura"] = date("Y-m-d H:i:s");

		return response() -> json(
			Chamado::create($request->all()),
			200
		);
	}

	public static function tooManyChamados(int $sigla) {
		$i = 0;
		$problemas = array();

		$chamados = Chamado::all();
		foreach($chamados as $chamado) {
			$ch = json_decode($chamado);
			if ($ch->sigla == $sigla)
				$problemas[$i++] = $ch->problema;
		}
		// RETURN array of problems if they are more than five AND BLOCK new support requests
		if ($i >= 5) return $problemas;
		return false;
	}
}
