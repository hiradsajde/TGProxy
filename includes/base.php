<?php
$root = 'http://'.$_SERVER['HTTP_HOST'].strtr(realpath(__DIR__),[$_SERVER['DOCUMENT_ROOT'] => null , 'includes' => null]);

// source setting 
define('channel',true); //is send proxy to channel?
define('grabber',true); //is grab proxy now?
define('checking',true); // is delete bad proxies?
// main varables
define('TOKENBOT',''); # bot tokan from @botfather
define('ADMINID' , ''); // bot admin unique id
// channel info 
$channel_id = ''; // unique id
$username = ''; //username @example
// checking info 
$ping_limit = 400; // limit proxy ping for checking