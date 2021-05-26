<?php
//session_start();
//session_destroy();
if( !isset($_SESSION['staff_id']) || !isset($_SESSION['name']) ){
    header( "location: index.php" );
}else{
    include '../connect-db.php';
    $strSQL = "SELECT receipts.facebook_id, SUM(receipts.point) AS total_point , users.name, users.picture
                FROM receipts INNER JOIN users WHERE receipts.facebook_id=users.facebook_id
                GROUP BY receipts.facebook_id 
                ORDER BY total_point DESC 
                LIMIT 10 ;";
    $result = $conn->query($strSQL);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $ranking = $result->fetchall();
    /*echo '<pre>';
    print_r($ranking);
    echo '<pre>';*/
}
?>
<div class="container">
    <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col">pictuer</th>
            <th scope="col">name</th>
            <th scope="col">total point</th>            
            </tr>
        </thead>
        <tbody>            
            <?php
                $strTable = '';
                foreach($ranking as $row){
                    $strTable = $strTable.'<tr>';
                    $strTable = $strTable.'<td><img style="width: 50px" src="'.$row['picture'].'" /></td>';
                    $strTable = $strTable.'<td>'.$row['name'].'</td>';
                    $strTable = $strTable.'<td>'.$row['total_point'].'</td>';
                    $strTable = $strTable.'</tr>';
                }
                echo $strTable;
            ?>         
            
        </tbody>
    </table>
</div>
