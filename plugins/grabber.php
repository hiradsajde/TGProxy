<?php 
// ----- REQUIRES ------ //
require_once '../includes/sql.php';
// ----- FUNCTIONS ----- //
function extractor($val,$from){ // this function's for extract parametr from GET mthod
    return explode('&',explode($from.'=',$val)[1])[0];
}
function ping($host, $port, $timeout) 
{ // this function's for get a mtproto server ping
  $tB = microtime(true); 
  $fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
  if (!$fP) { return "down"; } 
  $tA = microtime(true); 
  return round((($tA - $tB) * 1000), 0); 
}
$url = file_get_contents("https://t.me/s/{$_GET[q]}"); //main channel address for extract proxies
preg_match_all('/"https:\\/\\/t.me\\/proxy?(.*?)"/', $url, $text);
foreach($text[0] as $value){
    $val = strtr($value , ['"' => null , 'amp;' => null]);
    $server = extractor($val,'server');
    $port = extractor($val,'port');
    $ping = ping($server,$port,5);
    $time = time();
    if($ping != "down"){
        $num_be = $conn->query("SELECT * FROM proxies WHERE connection='$val'");
        if($num_be->num_rows == 0){ //check if not inserted
            $conn->query("INSERT INTO proxies (ping,connection,time) VALUES ('$ping','$val','$time')");
        }
        else{
            $conn->query("UPDATE proxies SET ping='$ping' , time='$time' WHERE connection='$val'");
        }
    }
}