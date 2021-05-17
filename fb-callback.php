<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
$appid = '3765972670192167';
$appsecret = '3b947fc5413cc9e877c2f84451561772';
$fb = new Facebook\Facebook([
    'app_id' => '3765972670192167',
    'app_secret' => '3b947fc5413cc9e877c2f84451561772',
    'default_graph_version' => 'v2.10',
    ]);
  
  $helper = $fb->getRedirectLoginHelper();
  
  try {
    $accessToken = $helper->getAccessToken();
  } catch(Facebook\Exception\ResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exception\SDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
  
  if (! isset($accessToken)) {
    if ($helper->getError()) {
      header('HTTP/1.0 401 Unauthorized');
      echo "Error: " . $helper->getError() . "\n";
      echo "Error Code: " . $helper->getErrorCode() . "\n";
      echo "Error Reason: " . $helper->getErrorReason() . "\n";
      echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
      header('HTTP/1.0 400 Bad Request');
      echo 'Bad request';
    }
    exit;
  }
  
  // Logged in
  echo '<h3>Access Token</h3>';
  var_dump($accessToken->getValue());
  
  // The OAuth 2.0 client handler helps us manage access tokens
  $oAuth2Client = $fb->getOAuth2Client();
  
  // Get the access token metadata from /debug_token
  $tokenMetadata = $oAuth2Client->debugToken($accessToken);
  echo '<h3>Metadata</h3>';
  var_dump($tokenMetadata);
  
  // Validation (these will throw FacebookSDKException's when they fail)
  //$tokenMetadata->validateAppId($config['app_id']);
  $tokenMetadata->validateAppId('3765972670192167');
  // If you know the user ID this access token belongs to, you can validate it here
  //$tokenMetadata->validateUserId('123');
  $tokenMetadata->validateExpiration();
  
  if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
      $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exception\SDKException $e) {
      echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
      exit;
    }
  
    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
  }
  
  $_SESSION['fb_access_token'] = (string) $accessToken;
  
  // User is logged in with a long-lived access token.
  // You can redirect them to a members-only page.
  //header('Location: https://example.com/members.php');
  
?>