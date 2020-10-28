<?php

namespace App\Http\Controllers;

use App\Equipamento;

class EquipamentoController extends Controller
{
	public function index()
	{
		return Equipamento::all();
	}
}
