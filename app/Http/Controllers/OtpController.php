<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UsuarioController;

// PHPMailer
use App\PHPMailer_src\PHPMailer;
use App\PHPMailer_src\SMTP;
use App\PHPMailer_src\Exception;

class OtpController extends Controller
{
	static public function sendEmail(String $otp, String $email) {
		$mail = new PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = env('EMAIL_NAME');
			$mail->Password = env('EMAIL_PASSWORD');
			$mail->Port = 587;

			$mail->setFrom(env('EMAIL_NAME'));
			$mail->addAddress($email);

			$mail->isHTML(true);
			$mail->Subject = 'Codigo de acesso';
			$mail->Body    = "Seu codigo de acesso: <strong>{$otp}</strong>";
			$mail->AltBody = "Seu codigo de acesso: {$otp}";

			if($mail->send()) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			return false;
		}
	}

	public function genOTP(Request $request) {
		// CHECK if "email" exists
		if ($request["email"] == NULL) return response() -> json(["fullHash" => null], 200);

		// CHECK if email is on DB
		if (!UsuarioController::IsEmailOnDB($request["email"])) return response() -> json(["fullHash" => null], 200);

		// One Time Password
		$otp = random_int(100001, 999998);

		//     H :  i :  s
		$ttl = 3 * 60 * 60;

		// EXPIRE = date + Time to live
		$expires = time() + $ttl;

		// CRIPTOGRAPHY the data
		$data = "{$request['email']}.{$otp}.{$expires}";
		$hash = hash_hmac('sha256', $data, env('SECRET_KEY'));

		// SEND otp to email
		if(!OtpController::sendEmail("{$otp}", $request['email'])) return response() -> json(["fullHash" => null], 200);

		// RETURN the fullhash to user
		$fullHash = "{$hash}.{$expires}";
		return response() -> json(["fullHash" => $fullHash], 200);
	}

	public function check(Request $request) {
		// CHECK if "otp", "email" or "fullHash" exists
		if ($request["otp"] == NULL ||
			$request["email"] == NULL ||
			$request["fullHash"] == NULL) return response() -> json(["status" => -1], 200);

		// SEPARATE Hash value and expires from the hash returned from the user
		list($hashValue, $expires) = explode(".", $request["fullHash"], 2);

		// CHECK if expiry time has passed
		$now = time();
		if ($now > intval($expires)) return response() -> json(["status" => 0], 200);

		// CALCULATE new Hash with the same key and the same algorithm
		$data = "{$request['email']}.{$request['otp']}.{$expires}";
		$newCalculateHash = hash_hmac('sha256', $data, env('SECRET_KEY'));

		// CHECK if the hashes match
		if ($newCalculateHash === $hashValue) return response() -> json(["status" => 1], 200);
		return response() -> json(["status" => -2], 200);
	}
}
