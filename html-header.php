<?php
if (isset($_SESSION['fb_access_token'])){
    $loginMenu['link'] = 'logout.php';
    $loginMenu['img'] = 'images/template/facebook.png';
    $loginMenu['text'] = 'ออกจากระบบ';
}else{
    $loginMenu['link'] = 'login.php';
    $loginMenu['img'] = 'images/template/facebook.png';
    $loginMenu['text'] = 'เข้าสู่ระบบ';
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
            <div class="navbar-brand">
                <img style="width: 30px" src="images/template/minmin_logo.png">
            </div>
            <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link active" href="<?php echo $loginMenu['link']?>">
                <img style="width: 30px" src="<?php echo $loginMenu['img']?>">
                <?php echo $loginMenu['text']?>
                <span class="sr-only">(current)</span></a>
            </div>
        </nav>