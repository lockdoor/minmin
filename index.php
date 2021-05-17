<?php
require_once __DIR__ . '/vendor/autoload.php';
$appid = '3765972670192167';
$appsecret = '3b947fc5413cc9e877c2f84451561772';
$fb = new Facebook\Facebook([
  'app_id' => '3765972670192167',
  'app_secret' => '3b947fc5413cc9e877c2f84451561772',
  'default_graph_version' => 'v2.10',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://namning.xyz/fb-callback.php', $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
?>