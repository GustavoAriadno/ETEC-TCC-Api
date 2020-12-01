<?php

namespace App\Http\Controllers;

use App\Local;
use Illuminate\Http\Request;

class LocalController extends Controller
{
	public function index() {
		return Local::all();
	}

	public function show(Request $request) {
		$local = Local::find($request["id"]);
		if (is_null($local)) return response() -> json(null, 204);
		return ($local);
	}

	public static function getName(int $id) {
		$local = Local::find($id);
		if (is_null($local)) return null;
		return json_decode($local)->nome;
	}
}
