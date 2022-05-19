<?php 
//read all params
require_once("__config__/__topmost__.php");
require_once("jwt.php");

$request = Request::getInstance();

$action = read_param($request->a, '');
$idno = read_param($request->idno, '0');
$userid = read_param($request->userid, 'NaN');
$pword = read_param($request->pwd, '');
$checkExistence = read_param($request->chk, '1');

//check the token first
$token = MyJWT::getToken();
$verifier = json_decode(MyJWT::verify($token));

$needAuth = true;
//token is still valid
if($verifier->result && $verifier->idno>0 && $verifier->exp >= time() && $verifier->userid === $userid && $verifier->idno == $idno){
	$needAuth = false;
} else{	
	//echo 'invalid data';
	$verifier->error = "need to login first";
	$needAuth = true;
}

$rows = array(
	'result'	=> false,
	'info'		=> ''
);

$existed = 1;
if($needAuth && $action == "auth"){	
	$rows = MyJWT::authenticate($userid, $idno);

	if($checkExistence==1){
		//todo: you database functions
		require_once "prf.db.php";
		$existed = Profile_CheckIfProfileExists($userid, $pword);	
	}
}

//TODO: do something more for user after login, such as configuration be user	
if($existed==1){	
	$crmData="";//fetching some more info here if needed
	$rows["config"]= base64_encode($crmData);
}
//if account not valid, just return null token and exp=-1
else{
	$rows['token']=null;
	$rows["exp"] = -1;
}

if(!is_string($rows)){
	$rows = json_encode($rows);
}

echo $rows;
?>