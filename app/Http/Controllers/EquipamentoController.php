<?php

namespace App\Http\Controllers;

use App\Equipamento;
use Illuminate\Http\Request;
use App\Http\Controllers\LocalController;

class EquipamentoController extends Controller
{
	public function index() {
		return Equipamento::all();
	}

	public function show(Request $request) {
		$equipamento = Equipamento::find($request["id"]);
		if (is_null($equipamento)) return response() -> json(null, 204);
		return ($equipamento);
	}

	public function getStrLocal(Request $request) {
		[$idEquipamento, $idLocal] = EquipamentoController::isSiglaOnDB($request["sigla"]);
		if ($idLocal == 0) return response() -> json(["status" => -1], 200);
		$localNome = LocalController::getName($idLocal);
		if (is_null($localNome)) return response() -> json(["status" => -2], 200);
		
		return response() -> json([
			"status" => 1,
			"sigla" => $request["sigla"],
			"local" => $localNome
		], 200);
	}

	public static function isSiglaOnDB(String $sigla) {
		$equipamento = Equipamento::where('sigla', $sigla)->first();
		if (is_null($equipamento)) return [0, 0];
		return [$equipamento->id, $equipamento->idLocal];
	}
}
