<?php
session_start();
//session_destroy();
if( !isset($_SESSION['staff_id']) || !isset($_SESSION['name']) ){
    header( "location: index.php" );
}else{
    $staff_id = $_SESSION['staff_id'];
    $admin_name = $_SESSION['name'];

    if(isset($_SESSION['bodyURL'])){
        $bodyURL = $_SESSION['bodyURL'];
        if( isset($_POST['bodyURL']) ){
            $_SESSION['bodyURL'] = $_POST['bodyURL'];            
            exit;
        }
    }else{
        $bodyURL = 'ranking.php';
        $_SESSION['bodyURL'] = $bodyURL;
    }    
}
?>
<!-- html area -->
<?php include 'html-header.php';?>
    

<?php include $bodyURL;?>

<?php include 'html-footer.php';?>