<?php

namespace App\Http\Controllers;

use App\Chamado;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
	public function index() {
		return Chamado::all();
	}

	public function show(int $id) {
		$chamado = Chamado::find($id);
		if (is_null($chamado)) return response() -> json(null, 204);
		return ($chamado);
	}

	public function store(Request $request) {
		// CHECK if the user EMAIL is in the database and GET id from user
		$request["idUsuario"] = UsuarioController::IsEmailOnDB($request["email"]);
		if (!$request["idUsuario"]) return response() -> json(null, 200);

		// GET idEquipamento and idLocal from database
		[$request["idEquipamento"], $request["idLocal"]] = EquipamentoController::isSiglaOnDB($request["sigla"]);
		if (!$request["idEquipamento"] || !$request["idLocal"]) return response() -> json(null, 200);

		// DATE of support request
		$request["dataAbertura"] = date("Y-m-d H:i:s");

		return response() -> json(
			Chamado::create($request->all()),
			201
		);
	}

	public static function tooManyChamados(int $sigla) {
		$i = 0;
		$problemas = array();
		// foreach(Chamado::all() as $chamado) if (json_decode($chamado)->sigla == $sigla) $problemas[$i++] = json_decode($chamado)->problema;
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
