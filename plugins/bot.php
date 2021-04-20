<?php
function ping($host, $port, $timeout) 
{ // this function's for get a mtproto server ping
  $tB = microtime(true); 
  $fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
  if (!$fP) { return "down"; } 
  $tA = microtime(true); 
  return round((($tA - $tB) * 1000), 0); 
}
function bot($method,$datas=[]){
    global $from_id;
    $url = 'https://api.telegram.org/bot'.TOKENBOT.'/'.$method;
    $ch = new Zebra_cURL();
    $ch->post([$url => $datas],function($res){
        if(!$res->response[1] == CURLE_OK){
        trigger_error('cURL responded with: ' . $result->response[0], E_USER_ERROR);
        }else{
            return json_decode($res);
        }
        send(ADMINID,var_export($res,true));
    });
    
}
function sendMessage($from_id,$text,$key=null,$markdown='html'){
    bot('sendMessage',['chat_id'=>$from_id,'text'=>$text,'reply_markup'=>$key,'parse_mode'=>$markdown]);
}
function editMessage($from_id,$text,$key=null,$markdown='html'){
    global $message_id;
    bot('editmessagetext',['chat_id'=>$from_id,'text'=>$text,'reply_markup'=>$key,'parse_mode'=>$markdown,'message_id' => $message_id,'disable_web_page_preview' => true]);
}
function extractor($val,$from){ // this function's for extract parametr from GET mthod
    return explode('&',explode($from.'=',$val)[1])[0];
}