<?php
session_start();
//session_destroy();
if( !isset($_SESSION['staff_id']) || !isset($_SESSION['name']) ){
    header( "location: index.php" );
}else{
    $receipt_id = $_POST['receipt_id'];
    $receipt_no = $_POST['receipt_no'];
    $point = intval($_POST['point']);
    //echo $point;
    $staff_id  = $_SESSION['staff_id'];
    include '../connect-db.php';
    $today = new DateTime();
    $todayStr = $today->format('Y-m-d H:i:s');
    $strSQL = "UPDATE receipts SET receipt_no=:receipt_no, verify=1, verify_date='".$todayStr."', staff_id='".$staff_id."', point=".$point." WHERE receipt_id=:receipt_id;";
    try{
        $query = $conn->prepare($strSQL);
        $query->bindParam(':receipt_no', $receipt_no);
        $query->bindParam(':receipt_id', $receipt_id);
        $query->execute();
        echo "Update Success";
    }catch(PDOException $e){
        if($e->getCode() == 23000){
            echo "Error: Receipt number already exist";
        }else{
            echo "Error: " . $e->getMessage();
        }
    }
    $conn = null;
}
    
?>