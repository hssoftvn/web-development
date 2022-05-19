<?php
require_once('utils.cmd');
require_once('jwt.core.php');
require_once('request.php');

$request = Request::getInstance();
$iss=read_param($request->iss, false);

//Expiration in seconds

$token_expiration = 10 * 60;
if($iss=='am'){
    $token_expiration = 2 * 60 * 60;
}

// Get our server-side secret key from a secure location.
define ("SERVER_KEY", '[YOUR_SEVER_KEY_HERE]');
define ("ALGORITHM", 'HS256');
define ("EXPIRATION_TIMES", $token_expiration); //in seconds

class MyJWT{

    public static function authenticate($userid, $idno){
            $nbf = time();
            //expire after 30 mins effective.
            $exp = $nbf + EXPIRATION_TIMES ;
            
            // create a token
            $payloadArray = array();
            $payloadArray['userid'] = $userid;
            $payloadArray['idno'] = $idno;
            $payloadArray['nbf'] = $nbf;
            $payloadArray['exp'] = $exp;

            $token = JWT::encode($payloadArray, SERVER_KEY);

            // return to caller
            $returnArray = array(
                'token' => $token,
                'exp'   => $exp
            );
            return $returnArray;
            //return json_encode($returnArray, JSON_PRETTY_PRINT);        
    }

    public static function verify($token){        
            if (!is_null($token)) {
                try {
                    $payload = JWT::decode($token, SERVER_KEY, array(ALGORITHM));                    
                    $returnArray = array(
                        'result' => true,
                        'scope' => 'verify',
                        'userid' => $payload->userid,
                        'idno' => (int) $payload->idno
                    );
                    if (isset($payload->exp)) {
                        //$returnArray['exp'] = date(DateTime::ISO8601, $payload->exp);
                        $returnArray['exp'] = $payload->exp;                        
                    }
                }
                catch(Exception $e) {
                    $returnArray = array(
                        'result' => false,
                        'scope' => 'verify',
                        'error' => $e->getMessage()
                    );
                }
            } 
            else {
                $returnArray = array(
                    'result' => false,
                    'scope' => 'verify',
                    'error' => 'Forbidden.'
                );
            }
            
            // return to caller
            $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
        
        return $jsonEncodedReturnArray;
    }

    public static function getToken(){
        return JWT::getToken();
    }

}
?>