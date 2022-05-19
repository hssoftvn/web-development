<?php

FUNCTION Profile_CheckIfProfileExists($userid, $pword){
	$email = preg_replace("/[^0-9a-zA-Z]/",".", $userid);	
	return file_exists("data/$email.json");
    //return ($userid!="" && $pword!="");
}

function Profile_fetchInfo($idno, $userid){
	$email = preg_replace("/[^0-9a-zA-Z]/",".", $userid);	
	$file = "data/$email.json";
	if(file_exists($file)){
		return file_get_contents($file);
	} else {
		return "no data";
	}
}

function Profile_saveInfo($idno, $userid, $info){
	$email = preg_replace("/[^0-9a-zA-Z]/",".", $userid);	
	$file = "data/$email.json";
	$data = [
		"Id"	=>	$idno,
		"Name"	=> $info,
		"Email"	=> $userid
	];
	$result = file_put_contents($file, json_encode($data));

	return [
		"result" => $result>0? 'success':'failed'		
	];
}
?>