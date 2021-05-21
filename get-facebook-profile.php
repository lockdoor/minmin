<?php
session_start();
//session_destroy();
if(!$_SESSION['fb_access_token']){
    header( "location: index.php" );
}else{
    //require_once __DIR__ . '/vendor/autoload.php';
    include 'config.php';
      
    try {
    // Returns a `Facebook\Response` object
    $response = $fb->get('/me?fields=id,name,email,picture.type(large)', $_SESSION['fb_access_token']);
    } catch(Facebook\Exception\ResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
    } catch(Facebook\Exception\SDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
    }
      
    $user = $response->getGraphUser();
    
    /*echo 'Name: ' . $user['name'].'<br>';
    echo 'token: ' . $_SESSION['fb_access_token'].'<br>';

    echo '<a href="logout.php">log out</a><br>';

    echo gettype($user);
    echo '<pre>';
    print_r($user);
    echo '</pre>';
    foreach($user as $value){
        echo $value.'<br>';
    }
    echo "<img src='".$user['picture']['url']."' alt='img'>"; */ 
    $_SESSION['facebookProfile']['id'] = $user['id'];
    $_SESSION['facebookProfile']['name'] = $user['name'];
    $_SESSION['facebookProfile']['email'] = $user['email'];
    $_SESSION['facebookProfile']['picture']['url'] = $user['picture']['url'];

    //echo $_SESSION['facebookProfile']['name'];
    //echo $_SESSION['facebookProfile']['id'];
    header("location: connect-db.php");
}

?>
