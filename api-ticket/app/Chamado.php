<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
	// protected $table = "chamados";

	protected $fillable = [
		'problema',
		'idLocal',
		'idEquipamento',
		'idUsuario',
		'dataAbertura',
		'prioridade'
	];
}
