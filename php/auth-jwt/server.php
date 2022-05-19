<?php 
//read all params
require_once "utils.cmd";
require_once "request.php";
require_once "tokencheck.php";

$request = Request::getInstance();

$action = read_param($request->a, 'none');

$idno = read_param($request->idno, '0');
$userid = read_param($request->userid, '0');
$pword = read_param($request->pwd, '');
$message = read_param($request->msg, '');

$verifier = TokenCheck::checkToken();
if(!$verifier->result || $verifier->userid !== $userid || $verifier->idno != $idno){
	TokenCheck::exitWithData($verifier);
}

$rows = [
	"result"	=>	"failed",
	"info"		=>	""
];

if($action == "info" && $idno > 0 && strlen($userid) > 8 ){	
	require_once "prf.db.php";
	$rows = Profile_fetchInfo($idno, $userid);
	
	echo_return($rows);
	exit();
}

if($action == "save" && $idno > 0 && strlen($userid) > 8 && strlen($message)>0 ){	
	require_once "prf.db.php";
	$rows = Profile_saveInfo($idno, $userid, "$message.");
	
	echo_return($rows);
	exit();
}

if(!is_string($rows)){
	$rows = json_encode($rows);
}

echo $rows;
?>