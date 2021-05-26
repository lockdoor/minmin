<?php
session_start();
//session_destroy();
if(!$_SESSION['fb_access_token'] || !$_SESSION['facebookProfile']){
    header( "location: index.php" );
}else{
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
    //#ตรวจสอบว่ามีการลงทะเบียนหรือยัง ถ้ายังให้ลงทะเบียนก่อน   
    include 'connect-db.php';
    $user = $_SESSION['facebookProfile'];    
    $strSQL = "SELECT facebook_id FROM users WHERE facebook_id=:facebook_id;";
    $query = $conn->prepare($strSQL);
    $query->bindParam(':facebook_id', $user['id']);
    $query->execute();    
    $result = $query->fetch(PDO::FETCH_ASSOC);    
    $today = date('Y-m-d H:i:s');
    //#ถ้ายังไม่ได้ลงทะเบียนก็ให้บันทึกข้อมูลลงทะเบียนในฐานข้อมูล
    if(!$result){
         $strSQL = "INSERT INTO users (facebook_id, name, email, picture, create_date, login_date)\n
         VALUES (:facebook_id, :name, :email, :picture, :create_date, :login_date);";
         $query = $conn->prepare($strSQL);
         $query->bindParam(':facebook_id', $user['id']);
         $query->bindParam(':name', $user['name']);
         $query->bindParam(':email', $user['email']);
         $query->bindParam(':picture', $user['picture']['url']);
         $query->bindParam(':create_date', $today);
         $query->bindParam(':login_date', $today);
         $query->execute();
    }
    
    //#ลงทะเบียนแล้ว login เข้ามาให้บันทึกเวลา login ใหม่ทุกครั้ง
    //$strSQL = "UPDATE users SET login_date='".$today."' WHERE facebook_id='".$user['id']."';";
    $strSQL = "UPDATE users SET login_date=:login_date WHERE facebook_id=:facebook_id;";
    $query = $conn->prepare($strSQL);
    $query->bindParam(':login_date', $today);
    $query->bindParam(':facebook_id', $user['id']);
    $query->execute();
    
    //#ดึงข้อมูลมาแสดงในตาราง    
    $strSQL = "SELECT receipts.receipt_no, receipts.receipt_date, receipts.verify_date,\n
                receipts.point, receipts.picture FROM receipts INNER JOIN users \n
                 ON receipts.facebook_id=users.facebook_id WHERE users.facebook_id=:facebook_id ORDER BY receipts.receipt_date DESC;";    
    $query = $conn->prepare($strSQL);
    $query->bindParam(':facebook_id', $user['id']);
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $dataTable = $query->fetchAll();
    
    //#รวมคะแนนเอาไปแสดงใต้ภาพ
    $strSQL = "SELECT SUM(point) as total FROM receipts WHERE facebook_id=:facebook_id;";
    $query = $conn->prepare($strSQL);
    $query->bindParam(':facebook_id', $user['id']);
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $sumPoint = $query->fetch();
    
    $query = null;
    $conn = null;   

    //อัพรูป upload-img.php;  
}
?>

<!-- html area -->
<?php include 'html-header.php'; ?>
    <div class='container'>
        <div class="row">
            <div class="col-md-4 text-center">
                <img class="pt-4 pb-4" src="<?php echo $user["picture"]["url"]?>">
                <p class=''>ชื่อผู้ใช้ : <?php echo $user['name']?></p>
                <p class=''>คะแนนรวม : <?php echo $sumPoint['total']?></p>
                
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
                                    $strTable = $strTable.'<td><img src="'.$value.'" style="width: 50px" onclick="showPictureModal( \''.$picture.'\')" /></td>';
                                }else{
                                    $strTable = $strTable.'<td>'.$value.'</td>';
                                }
                            }
                            $strTable = $strTable.'<tr>';                      
                        }
                        echo $strTable;
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
        
    </div>

    <script>
        function showPictureModal(pictureUrl){
            $('#modal-Image').attr("src", pictureUrl);                      
        }
    </script>

    <!-- Modal -->
    <div class="modal fade modal-dialog modal-dialog-scrollable" id="staticBackdrop" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-body text-center">      
                    <img id="modal-Image" src="" />        
                </div>                
                
            </div>
        </div>
    </div>
<?php include 'html-footer.php';?>