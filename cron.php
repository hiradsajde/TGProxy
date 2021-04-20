<?php
error_reporting(0);
require_once 'includes/sql.php';
require_once 'includes/zebra_curl.php';
require_once 'includes/base.php';
require_once 'plugins/bot.php';
if(grabber){
    $proc = pcntl_fork();
    if($proc){
        $curl = new Zebra_cURL();
        $curl->scrap($root.'multiRequest.php', true);
    }
}
if(channel){
    $proc = pcntl_fork();
        if($proc){
        $select_proxy = $conn->query("SELECT * FROM proxies ORDER BY time DESC , ping ASC LIMIT 5 OFFSET 0");
        while($fetch_proxy = $select_proxy->fetch_assoc()){
            $keyboard = json_encode(['inline_keyboard' => [
                [['text' => 'Conenct now!' , 'url' => $fetch_proxy['connection']]] ,
            ]]);
            sendMessage($channel_id,
            "🔑 Use the button for connect to proxy ". PHP_EOL.PHP_EOL.
    
            "⚠️ از دکمه برای اتصال به پروکسی استفاده کنید ".PHP_EOL.PHP_EOL.
    
            "🆔 $username"
            ,$keyboard);
        }
    }
}
if(checking){
    $proc = pcntl_fork();
    if($proc){
        $select_time = time() - (60*60);
        $select_proxy = $conn->query("SELECT * FROM proxies WHERE time > $select_time");
        while($fetch_proxy = $select_proxy->fetch_assoc()){
            $val = strtr($fetch_proxy['connection'] , ['"' => null , 'amp;' => null]);
            $server = extractor($val,'server');
            $port = extractor($val,'port');
            $ping = ping($server , $port , 5);
            $time = time();
            if($ping < $ping_limit || $ping == 'down'){
                $conn->query("DELETE FROM proxies WHERE id='$fetch_proxy[id]'");
            }
            else{
                $conn->query("UPDATE proxies SET ping='$ping' , time='$time' WHERE id='$fetch_proxy[id]'");
            }
        }
    }
} 