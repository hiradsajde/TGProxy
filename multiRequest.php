<?php
# ------ REEQUIRES --------- #
require_once 'includes/sql.php';
require_once 'includes/zebra_curl.php';
require_once 'includes/base.php';
# ------ VARABLES ---------- #
$address = $root.'plugins/grabber.php';
# ------ MAIN CODES -------- #
$channels = [];
$select_channels = $conn->query("SELECT * FROM channels");
while($channels_fetch = $select_channels->fetch_assoc()){
    $channels[] = $channels_fetch['username'];
}
foreach($channels as $value){
    $proc = pcntl_fork();
    if($proc == -1){
        die('faild!');
    }
    else if($proc){
        $curl = new Zebra_cURL();
        $curl->scrap($address.'?q='.$value, true);
    }
    else{
        echo 'request sent success !';
    }
}
