<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
include 'config.php';
/*$fb = new Facebook\Facebook([
    'app_id' => $appid,
    'app_secret' => $appsecret,
    'default_graph_version' => 'v2.10',
    ]);*/
  
  $helper = $fb->getRedirectLoginHelper();
  
  $permissions = ['email']; // Optional permissions
  $loginUrl = $helper->getLoginUrl('fb-callback.php', $permissions);
  
  echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
?>