<?php
//https://github.com/facebookarchive/php-graph-sdk/tree/master/docs
//https://www.thaicreate.com/community/php-facebook-login-api-sdk-v5.html
require_once __DIR__ . '/vendor/autoload.php';
$appid = '3765972670192167';
$appsecret = '3b947fc5413cc9e877c2f84451561772';
//$website = 'https://namning.xyz/';
$website = 'http://localhost/minmin/';
$fb = new Facebook\Facebook([
    'app_id' => $appid,
    'app_secret' => $appsecret,
    'default_graph_version' => 'v2.10',
    ]);
//database

?>