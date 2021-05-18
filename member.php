<?php
session_start();
//session_destroy();
if(!$_SESSION['fb_access_token']){
    header( "location: index.php" );
}else{
    //require_once __DIR__ . '/vendor/autoload.php';
    include 'config.php';

//session time out    
    $sessionlifetime = 30; //กำหนดเป็นนาที
    if(isset($_SESSION["timeLasetdActive"])){
        $seclogin = (time()-$_SESSION["timeLasetdActive"])/60;
        //หากไม่ได้ Active ในเวลาที่กำหนด
        if($seclogin>$sessionlifetime){
            //goto logout page
            header("location:logout.php");
            exit;
        }else{
            $_SESSION["timeLasetdActive"] = time();
        }
    }else{
        $_SESSION["timeLasetdActive"] = time();
    }

    /*$fb = new Facebook\Facebook([
        'app_id' => '3765972670192167',
        'app_secret' => '3b947fc5413cc9e877c2f84451561772',
        'default_graph_version' => 'v2.10',
        ]); */   
      
    try {
    // Returns a `Facebook\Response` object
    $response = $fb->get('/me?fields=id,name', $_SESSION['fb_access_token']);
    } catch(Facebook\Exception\ResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
    } catch(Facebook\Exception\SDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
    }
      
    $user = $response->getGraphUser();
    
    echo 'Name: ' . $user['name'].'<br>';
    echo 'token: ' . $_SESSION['fb_access_token'].'<br>';

    echo '<a href="logout.php">log out</a>';
    
}

?>