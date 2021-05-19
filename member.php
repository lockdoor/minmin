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
    /*
    echo 'Name: ' . $user['name'].'<br>';
    echo 'token: ' . $_SESSION['fb_access_token'].'<br>';

    echo '<a href="logout.php">log out</a><br>';

    echo gettype($user);
    echo '<pre>';
    print_r($user);
    echo '</pre>';
    foreach($user as $value){
        echo $value.'<br>';
    }
    
   
    
    echo "<img src='".$user['picture']['url']."' alt='img'>";*/
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- Responsive for all device -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <title>Wellcome to lockdoor page</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link active" href="login.php">
                    <img style="width: 30px" src="images/template/facebook.png">
                    ออกจากระบบ
                    <span class="sr-only">(current)</span></a>
            </div>
        </nav>
        <div class='container'>
            <div class="row">
                <div class="col-sm-4 text-center">
                    <!--div class="row pt-4">
                        <div class="col text-center ">
                            <img class="" src="<?php //echo $user["picture"]["url"]?>">
                        </div>    
                    </div>
                    <div class="row text-center pt-4">
                        <div class="col text-center">
                            <p>ชื่อผู้ใช้ : <?php //echo $user['name']?></p>
                        </div>                        
                    </div-->
                    <img class="pt-4" src="<?php echo $user["picture"]["url"]?>">
                    <p class='pt-4'>ชื่อผู้ใช้ : <?php echo $user['name']?></p>
                    <p class='pt-1'>คะแนนรวม : </p>
                </div>
                <div class="col-md-8 text-center">
                    <p class="pt-4">{พื้นที่แสดงตารางการอัพใบเสร็จ}</p>
                </div>

            </div>
            
        </div>
    </body>
</html>