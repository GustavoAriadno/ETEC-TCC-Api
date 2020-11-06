<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
	// protected $table = "chamados";
	public $timestamps = false;

	protected $fillable = [
		'problema',
		'idLocal',
		'idEquipamento',
		'idUsuario',
		// 'prioridade',
		'dataAbertura'
	];
}
