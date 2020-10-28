<?php

namespace App\Http\Controllers;

use App\Equipamento;

class EquipamentoController extends Controller
{
	public function index()
	{
		return Equipamento::all();
	}

	public function show(int $id){
		$equipamento = Equipamento::find($id);
		if (is_null($equipamento)) return response() -> json(null, 204);
		return ($equipamento);
	}
}
