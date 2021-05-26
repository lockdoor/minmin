<?php
if( !isset($_SESSION['staff_id']) || !isset($_SESSION['name']) ){
    header( "location: index.php" );
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" href="../images/template/minmin_logo.png" type="image/png" sizes="16x16">
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
    <script>
            $(document).ready(function(){
                $('.navbar-nav li').click(function(){                    
                    var bodyURL = $(this).attr('value');
                    //console.log(bodyURL);
                    $.ajax({        
                        //url: "admin.php",
                        type: "POST",
                        data: {bodyURL : bodyURL},                
                        success: function(response){
                            //console.log(response);
                            location.reload();                   
                        },
                    });                    
                });            
            });
        </script>       
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="navbar-brand">
            <img style="width: 30px" src="../images/template/minmin_logo.png">
            <span class="nav-item">ผู้เข้าใช้งาน: <?php echo $admin_name?></span>                
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item"  id="linkItem1" value="ranking.php" >
                <a class="nav-link" href="#">อันดับคะแนน </a>
            </li>
            <li class="nav-item" id="linkItem1" value="show-receipt.php" >
                <a class="nav-link"  href="#">ตรวจสอบใบเสร็จ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">ออกจากระบบ</a>
            </li>      
            </ul>
        </div>
        </nav>