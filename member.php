<?php
session_start();
//session_destroy();
if(!$_SESSION['fb_access_token']){
    header( "location: index.php" );
}else{
    //require_once __DIR__ . '/vendor/autoload.php';
    //include 'config.php';

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
    

    //ตรวจสอบว่ามีการลงทะเบียนหรือยัง ถ้ายังให้ลงทะเบียนก่อน   
    include 'connect-db.php';
    $user = $_SESSION['facebookProfile'];    
    $strSQL = "SELECT facebook_id FROM users WHERE facebook_id='".$user['id']."';";
    $result = $conn->query($strSQL) or die ('can not find user'.$result);
    $today = date('Y-m-d H:i:s');
    //if($result->num_rows == 0){
    if(!$result){
        $strSQL = "INSERT INTO users (facebook_id, name, email, picture, create_date, login_date)\n
         VALUES ('".$user['id']."', '".$user['name']."', '".$user['email']."', '\n"
         .$user['picture']['url']."', '".$today."', '".$today."');";        
        $result = $conn->query($strSQL)or die ('can not insert user to db');
    }
    
    //ลงทะเบียนแล้ว login เข้ามาให้บันทึกเวลา login ใหม่ทุกครั้ง
    $strSQL = "UPDATE users SET login_date='".$today."' WHERE facebook_id='".$user['id']."';";
    $conn->query($strSQL);
    
    //ดึงข้อมูลมาแสดง
    $strSQL = "SELECT receipts.receipt_no, receipts.receipt_date, receipts.verify_date,\n
                receipts.point, receipts.picture FROM receipts INNER JOIN users \n
                 ON receipts.facebook_id=users.facebook_id WHERE users.facebook_id='".$user['id']."' ORDER BY receipts.receipt_date DESC;";
    $dataTable = $conn->query($strSQL) or die ('con not get dataTable');
    $conn->close();   
    //echo $dataTable->num_rows;
    
    /*foreach($dataTable as $item){
        foreach($item as $value){
            print (isset($value)) ? $value.'<br>' : 'null <br>';
            
        }
    }*/
    //อัพรูป upload-img.php;  
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
        <style>
            input, button {
                /*font-size: 60px;*/
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link active" href="logout.php">
                <img style="width: 30px" src="images/template/facebook.png">
                ออกจากระบบ
                <span class="sr-only">(current)</span></a>
            </div>
        </nav>
        <div class='container'>
            <div class="row">
                <div class="col-md-4 text-center">
                    <img class="pt-4 pb-4" src="<?php echo $user["picture"]["url"]?>">
                    <p class=''>ชื่อผู้ใช้ : <?php echo $user['name']?></p>
                    <p class=''>คะแนนรวม : </p>
                    
                    <!--input img start-->
                    <script src="js/img_resize.js"></script>                                       

                    <div class="input-group mb-3">
                        <div hidden class="input-group-prepend" id="btnUpload">
                            <span class="input-group-text" onclick="process('<?php echo $user['id']?>', image) ">UPLOAD</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" id="upload" class="custom-file-input" accept=".jpg, .jpeg, .png" onchange="preview()" />
                            <label class="custom-file-label" for="upload">Choose file</label>
                        </div>
                    </div>
                    <div><img class='img-fluid' id="output" /></div>                 

                    <!--input img end-->
                </div>

                <div class="col-md-8 text-center">
                    <p class="pt-4">{พื้นที่แสดงตารางการอัพใบเสร็จ}</p>
                    <table class="table table-hover">
                     <thead>
                      <tr>
                       <th scope="col">receipt_no</th>
                       <!--th scope="col">verify</th-->
                       <th scope="col">receipt_date</th>
                       <th scope="col">verify_date</th>
                       <!--th scope="col">vender</th-->
                       <th scope="col">point</th>
                       <th scope="col">picture</th>
                      </tr>
                     </thead>
                     <tbody>
                     <?php
                        $strTable = '';
                        foreach($dataTable as $item){
                            $strTable = $strTable.'<tr>';
                            $numberItems = count($item);
                            $i = 0;
                            foreach($item as $value){
                                
                                if(!isset($value)) $value = 'รอการตรวจสอบ';
                                if(++$i === $numberItems){
                                    $strTable = $strTable.'<td><a href="'.$value.'" target="_blank"><img src="'.$value.'" style="width: 50px" /></a></td>';
                                }else{
                                    $strTable = $strTable.'<td>'.$value.'</td>';
                                }
                            }
                            $strTable = $strTable.'</tr>';                            
                        }
                        echo $strTable;
                     ?>
                     </tbody>
                    </table>
                </div>

            </div>
            
        </div>
    </body>
</html>