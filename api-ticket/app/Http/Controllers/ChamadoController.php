<?php

namespace App\Http\Controllers;

use App\Chamado;
use App\Equipamento;
use App\Local;

class ChamadoController extends Controller
{
	public function index()
	{
		return Chamado::all();
	}
	public function nome(String $sigla)
	{
		// $idLocal = -1;
		// $idEquipamento = -1;
		// $searchforlocal = -1;
		$len = strlen($sigla);
		while($len) {
			if ($sigla[$len - 1] == 'M' &&
				($sigla[$len] == 'P' || is_numeric($sigla[$len])))
			{
				$searchforlocal = substr($sigla, 0, --$len);
				break;
			}
			$len--;
		}
		$equipamentos = Equipamento::all();
		foreach($equipamentos as $eq) {
			$data = json_decode($eq);
			if ($data->sigla == $sigla) {
				$idEquipamento = $data->id;
				break;
			}
		}
		$locais = Local::all();
		foreach($locais as $local) {
			$data = json_decode($local);
			if ($data->sigla == $searchforlocal) {
				$idLocal = $data->id;
				break;
			}
		}
		echo $idLocal;
		echo " ";
		echo $idEquipamento;
		// if (Some variable is negative) echo "ERRO";
		// return response() -> json(null, 200);
	}
}
