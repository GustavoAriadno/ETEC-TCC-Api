<?php

namespace App\Http\Controllers;

use App\Local;

class LocalController extends Controller
{
	public function index() {
		return Local::all();
	}

	public function show(int $id) {
		$local = Local::find($id);
		if (is_null($local)) return response() -> json(null, 204);
		return ($local);
	}
}
