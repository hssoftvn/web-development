<?php

function IsUtilsClassDefined(){
	return true;
}

FUNCTION DBG($info){
	//echo $info.'<br>';
}

FUNCTION RESPONSE($info){
	//echo $info;
}

FUNCTION RES_SUCCESS(){
	//echo "SUCCESS";
}

FUNCTION RES_FAILED(){
	//echo "FAILED";
}

FUNCTION uniqidReal($lenght = 14) {
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {        
		$byte = uniqid();
		//throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}

FUNCTION decode_1x($data){	
	$data = base64_decode($data);
	return $data;
}
FUNCTION decode_3x($data){
	//the query was encoded 3 times
	//so have to decode 3 times
	$data = base64_decode($data);
	$data = base64_decode($data);
	$data = base64_decode($data);
	
	return $data;
}
FUNCTION is_base64_encoded($str) {
	$decoded_str = base64_decode($str);
	$Str1 = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $decoded_str);
	if ($Str1!=$decoded_str || $Str1 == '') {
		return false;
	}
	return true;
}

function is_empty($input){
    return ($input == false || $input == "");
}

function is_not_empty($input){
    return ($input != false && $input != "");
}

FUNCTION read_param($param, $default_value=""){
	return is_empty($param)? $default_value:$param;
}


FUNCTION echo_return($result){
	if(!is_string($result)){
		$result = json_encode($result);
	}
	
	echo $result;
}

function dbg_sql($sql){
	echo "$sql";
	exit();
}

function to_plain_text($string){
	$res = preg_replace("/[^a-zA-Z0-9\s-]/", "", $string);  
	$res = preg_replace("/[\s]/", "-", $res);	  
	return $res;
}

function tokenizeSentence($sentence){
	$t = new TextTokenizer($sentence);
	$retSent = "";
	while (list($token) = $t->token()) {
		$retSent .= "$token ";
	}

	return $retSent;
}

// Converts a number into a short version, eg: 1000 -> 1k
// Based on: http://stackoverflow.com/a/4371114
function fnumber1($n, $precision = 1) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } elseif ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n * 0.001, $precision);
        $suffix = 'K';
    } elseif ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n * 0.000001, $precision);
        $suffix = 'M';
    } elseif ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n * 0.000000001, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n * 0.000000000001, $precision);
        $suffix = 'T';
    }

    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }

    return $n_format . $suffix;
}

function mny2($value){ 
     $value = sprintf("%0.1f", $value);
     $vl = explode(".", $value);
     $value = number_format($vl[0]);
     if($vl[1]!="0")$value.=".".$vl[1];
     return $value;
}
function fnumber($n,$precision=1) {
  // the length of the n
  $len = strlen($n);
  // getting the rest of the numbers
  $rest = (int)substr($n,$precision+1,$len);
  // checking if the numbers is integer yes add + if not nothing
  $checkPlus = (is_int($rest) and !empty($rest))?"+":"";
  if ($n >= 0 && $n < 1000) {
    // 1 - 999
    $n_format = number_format($n);
    $suffix = '';
  } else if ($n >= 1000 && $n < 1000000) {
    // 1k-999k
    $n_format = number_format($n / 1000,$precision);
    $suffix = 'K'.$checkPlus;
  } else if ($n >= 1000000 && $n < 1000000000) {
    // 1m-999m
    $n_format = number_format($n / 1000000,$precision);
    $suffix = 'M'.$checkPlus;
  } else if ($n >= 1000000000 && $n < 1000000000000) {
    // 1b-999b
    $n_format = number_format($n / 1000000000);
    $suffix = 'B'.$checkPlus;
  } else if ($n >= 1000000000000) {
    // 1t+
    $n_format = number_format($n / 1000000000000);
    $suffix = 'T'.$checkPlus;
  }
  return !empty($n_format . $suffix) ? mny2($n_format) . $suffix: 0;
}

?>