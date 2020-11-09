<?php

namespace App\Http\Controllers;

use App\Equipamento;

class EquipamentoController extends Controller
{
	public function index() {
		return Equipamento::all();
	}

	public function show(int $id) {
		$equipamento = Equipamento::find($id);
		if (is_null($equipamento)) return response() -> json(null, 204);
		return ($equipamento);
	}

	public static function isSiglaOnDB(String $sigla) {
		// ONE LINE HERO
		// foreach(Equipamento::all() as $eq) if (json_decode($eq)->sigla == $sigla) return [json_decode($eq)->id, intval(json_decode($eq)->idLocal)];
		
		$equipamentos = Equipamento::all();
		foreach($equipamentos as $equipamento) {
			$eq = json_decode($equipamento);
			if ($eq->sigla == $sigla) return [$eq->id, intval($eq->idLocal)];
			// IDLOCAL IS RECEIVING A STRING, I don't know why
		}
		return [0, 0];
	}
}
