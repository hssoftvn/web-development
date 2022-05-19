<?php

$server_name = $_SERVER['SERVER_NAME'];
$url_origin = "https://hssoftvn.com";
$is_local = false;
if($server_name!="hssoftvn.com"){
    $url_origin = "http://localhost";	
    $is_local = true;
}

$current_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
?>