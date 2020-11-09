<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OtpController extends Controller
{
	private $proKey = 'chAVECHaVOsa123';
	
	public function send(Request $request) {
		// CHECK if "email" exists
		if ($request["email"] == NULL) return response() -> json(null, 200);
		// CHECK if email is on DB
		// if (!UsuarioController::IsEmailOnDB($request["email"])) return response() -> json(null, 200);

		// One Time Password
		$otp = random_int(100001, 999999);

		//     H :  i :  s :  mls
		// $ttl = 3 * 60 * 60 * 1000;
		$ttl = 5 * 60 * 1000;

		// EXPIRE = date + Time to live
		$expires = time() + $ttl;

		// CRIPTOGRAPHY the data
		$data = "{$request['email']}.{$otp}.{$expires}";
		$hash = hash_hmac('sha256', $data, $this->proKey);

		// SEND otp to email
		// sendemail($otp, $request['email']);

		// RETURN the fullhash to user
		$fullHash = "{$hash}.{$expires}";
		return $fullHash;
	}

	public function check(Request $request) {
		// CHECK if "otp", "email" or "fullHash" exists
		if ($request["otp"] == NULL ||
			$request["email"] == NULL ||
			$request["fullHash"] == NULL) return response() -> json(null, 200);
		// SEPARATE Hash value and expires from the hash returned from the user
		[$hashValue, $expires] = explode(".", $request["fullHash"]);

		// CHECK if expiry time has passed
		$now = time();
		if ($now > intval($expires)) return false;

		// CALCULATE new Hash with the same key and the same algorithm
		$data = "{$request['email']}.{$request['otp']}.{$expires}";
		$newCalculateHash = hash_hmac('sha256', $data, $this->proKey);

		// CHECK if the hashes match
		if ($newCalculateHash === $hashValue) return true;
		return false;
	}
}
