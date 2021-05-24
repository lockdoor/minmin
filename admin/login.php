<?php
session_start();
if( $_POST['loginname'] && $_POST['pw'] ){
    $loginname = $_POST['loginname'];
    //echo gettype($loginname).'  -  '.gettype($_POST['loginname']).'<br>';
    //echo 'loginname = '.$loginname.'<br>';
    $pw = md5($_POST['pw']);
    //echo 'password = '.$pw.'<br>';    
    //echo 'password = '.md5($pw).'<br>';    
    include '../connect-db.php';

    //sql for mysqli   
    //$strSQL = "SELECT * FROM staffs WHERE loginname='".$loginname."' AND password='".$pw."' ;"; 
    //sql for PDO
    $strSQL = "SELECT * FROM staffs WHERE loginname=:loginname AND password=:pw ;"; 
    
    //query by mysqli not protect sql injection
    //$result = $conn->query($strSQL) or die ('error user not found '.$conn->error.'<br>');
    //query by mysqli with protect sql injection
    /*$stmt = $conn->prepare('SELECT * FROM staffs WHERE loginname = ? AND password = ?');
    $stmt->bind_param('ss', $loginname, $pw);
    $stmt->execute();
    $result = $stmt->get_result();*/
    //query by PDO with protect sql injection
    $query = $conn->prepare($strSQL);
    $query->bindParam(':loginname', $loginname);
    $query->bindParam(':pw', $pw);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);   
    if($result){        
        $_SESSION['staff_id'] = $result['staff_id'];
        $_SESSION['name'] = $result['name'];
        $query = null;
        $conn = null;
        header( "location: admin.php" );   
    }else{
        echo 'user not found'.'<br>';
        $query = null;
        $conn = null;
        header( "location: index.php" );
    }
}else{
    echo 'sesion not found'.'<br>';    
    header( "location: index.php" );
}
?>