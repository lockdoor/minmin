<?php
session_start();
//session_destroy();
if( !isset($_SESSION['staff_id']) || !isset($_SESSION['name']) ){
    header( "location: index.php" );
}else{
    $staff_id = $_SESSION['staff_id'];
    $admin_name = $_SESSION['name'];
    
    include '../connect-db.php';
    //#นับจำนวนใบเสร็จที่ยังไม่มีการตรวจสอบ
    $strSQL = "SELECT COUNT(*) as total FROM receipts WHERE verify='0';";   
    $result = $conn->query($strSQL);
    //return sql object to array
    $totalReceiptNotVerify = $result->fetch(PDO::FETCH_ASSOC);    
ุ
    //#ดึงข้อมูลใบเสร็จที่ยังไม่ได้ตรวจสอบ
    $strSQL = "SELECT * FROM receipts WHERE verify='0'ORDER BY receipt_date DESC LIMIT 10;";    
    $receiptNotVerify = $conn->query($strSQL);
}
?>
<!-- html area -->
<?php include 'html-header.php';?>
    <div class=''>
        <p class="pt-4 text-center">{พื้นที่แสดงตารางใบเสร็จที่รอการตรวจสอบ}</p>
        <p class="pt-4 text-center">ยังมีใบเสร็จที่ไม่ได้ตรวจสอบ <?php echo $totalReceiptNotVerify['total']?></p>
        <div class="row">
            <?php
                $strDivStart = '<div class="col-xl-3 col-lg-4 col-md-6 mb-4 mb-lg-0 text-center border ">';
                $strDivEnd = '</div>';
                $str = '';
                foreach($receiptNotVerify as $row){
                    $picture = '../'.$row['picture'];
                    $str = $str.$strDivStart.'<img src="'.$picture.'" class="w-50 shadow-1-strong rounded mb-4" alt="'.$picture.'" /></div>';
                }
                echo $str;                  
            ?>
        </div>
    </div>
<?php include 'html-footer.php';?>