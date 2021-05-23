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
    $strSQL = "SELECT * FROM staffs WHERE loginname='".$loginname."' AND password='".$pw."' ;";    
    $result = $conn->query($strSQL) or die ('error user not found '.$conn->error.'<br>');
    //protect sql injection
    $stmt = $conn->prepare('SELECT * FROM staffs WHERE loginname = ? AND password = ?');
    $stmt->bind_param('ss', $loginname, $pw);
    $stmt->execute();
    $result = $stmt->get_result();
    //echo 'row = '.$result->num_rows.'<br>';     

    /*if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
            $_SESSION['staff_id'] = $row['staff_id'];
            $_SESSION['name'] = $row['name'];
            //header( "location: admin.php" );        
        }
    }else{
        echo 'user not found'.'<br>';
        //header( "location: index.php" );
    }*/
}else{
    echo 'sesion not found'.'<br>';
    //header( "location: index.php" );
}
?>