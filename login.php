<?php
session_start();

include 'config.php';

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl($website.'fb-callback.php', $permissions);
$fb_callback = 'Location: '.$loginUrl;
header($fb_callback);
//echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
?>