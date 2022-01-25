<?php
	define('METHOD','AES-256-CBC');
	define('SECRET_KEY','Marsoft2020*'); //
	//define('SECRET_KEY','Masa2020*');
	define('SECRET_IV','73429');
	class SED {
		public static function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}
		public static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}
	}

	// $obj = new SED();
	// echo "Contraseña encriptada: <br>".$obj->encryption("123456");