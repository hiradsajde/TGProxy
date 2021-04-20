<?php
# ------ REEQUIRES --------- #
require_once 'includes/sql.php';
require_once 'includes/zebra_curl.php';
require_once 'includes/base.php';
require_once 'plugins/bot.php';

# ------ VARABLES ---------- #
$datas = [];

# ------ MAIN CODES -------- #
$select_proxy = $conn->query("SELECT * FROM proxies ORDER BY time DESC , ping ASC LIMIT 5 OFFSET 0");
while($fetch_proxy = $select_proxy->fetch_assoc()){
    $val = strtr($fetch_proxy['connection'] , ['"' => null , 'amp;' => null]);
    $server = extractor($val,'server');
    $port = extractor($val,'port');
    $secret = extractor($val,'secret');
    $datas[] = [
        'server' => $server,
        'port' => $port,
        'secret' => $secret,
    ];
}

switch($_GET['type']){
    case 'random';
        echo json_encode($datas[rand(0,(count($datas)-1))]);    
    break;
    default;
        echo json_encode($datas);
    break;
}