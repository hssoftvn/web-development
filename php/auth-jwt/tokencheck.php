<?php
require_once("jwt.php");

class TokenCheck{
	public static function exitWithData($verifier){

		$rows['total_pages'] = 0;
		$rows['total_rows'] = 0;
		$rows['rows']=[];

		$rows['info'] = isset($verifier->error)? $verifier->error:"rejected";

		echo_return($rows);
		exit();
	}

	public static function checkToken(){
		$token = MyJWT::getToken();

		$verifier = json_decode(MyJWT::verify($token));
		$isValidToken = false;

		if($verifier->result && $verifier->idno>0 && $verifier->exp >= time() ){
			$isValidToken = true;
		} else{	
			$isValidToken = false;
			TokenCheck::exitWithData($verifier);
		}

		return $verifier;
	}

}
?>