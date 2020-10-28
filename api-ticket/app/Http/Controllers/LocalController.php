<?php

namespace App\Http\Controllers;

use App\Local;

class LocalController extends Controller
{
	public function index()
	{
		return Local::all();
	}
}
