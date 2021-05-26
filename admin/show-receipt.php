<?php
if( !isset($_SESSION['staff_id']) || !isset($_SESSION['name']) ){
    header( "location: index.php" );
}else{
    include '../connect-db.php';
    //#นับจำนวนใบเสร็จที่ยังไม่มีการตรวจสอบ
    $strSQL = "SELECT COUNT(*) as total FROM receipts WHERE verify=0;";   
    $result = $conn->query($strSQL);
    //#return sql object to array
    $totalReceiptNotVerify = $result->fetch(PDO::FETCH_ASSOC);

    //#ดึงข้อมูลใบเสร็จที่ยังไม่ได้ตรวจสอบ
    $strSQL = "SELECT * FROM receipts WHERE verify=0 ORDER BY receipt_date DESC LIMIT 10;";    
    $receiptNotVerify = $conn->query($strSQL);

    $conn = null;
}
?>

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
                    $str = $str.$strDivStart.'<img src="'.$picture.'" class="w-50 shadow-1-strong rounded mb-4"
                     data-toggle="modal" data-target="#staticBackdrop" alt="'.$picture.'" id="'.$row['receipt_id'].'" 
                     onclick="myfunc('.$row['receipt_id'].', \''.$picture.'\')" /></div>';
                }
                echo $str;                  
            ?>
        </div>
    </div>
<?php include 'html-footer.php';?>

<script>
    function myfunc(receipt_id, picture){
        $('#modal-Image').attr("src", picture);
        $('#staticBackdropLabelSpan').html(receipt_id);
        autoInput();            
    }
    function autoInput(){        
        $('#receipt_no').val(getRndInteger(1000000000, 10000000000));
        $('#point').val(getRndInteger(100, 1000));
    }
    function getRndInteger(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }
    $(document).ready(function(){
        $('#modalSubmitBtn').click(function(){            
            receipt_id = $('#staticBackdropLabelSpan').html();
            receipt_no = $('#receipt_no').val(); 
            point = parseInt($('#point').val());
            if(isNaN(point)){
                $('#point').val(null);
            }else{            
                console.log(receipt_id);
                console.log(typeof(receipt_no) + receipt_no);
                console.log(typeof(point) + point);
                $.ajax({        
                    url: "admin-verify.php",
                    type: "POST",
                    data: {receipt_id : receipt_id, receipt_no : receipt_no, point: point},                
                    success: function(response){
                        alert(response);
                        location.reload();                   
                    },
                });
            }
        });
    });
</script>

<!-- Modal -->
<div class="modal fade modal-dialog modal-dialog-scrollable" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">        
            
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">receipt id <span id="staticBackdropLabelSpan"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body text-center">      
                <img id="modal-Image" src="" />        
            </div>
            
            <div class="modal-footer">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">receipt number</span>
                    </div>
                    <input type="text" class="form-control" id="receipt_no" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
                <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">point</span>
                </div>
                <input type="number" class="form-control" id="point" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modalSubmitBtn">Submit</button>
            </div>
        </div>
    </div>
</div>