<?php
session_start();
if(!$_SESSION['fb_access_token']){
    header( "location: index.php" );
}else{
    //https://stackoverflow.com/questions/49759386/resize-image-in-the-client-side-before-upload
    define('UPLOAD_DIR', 'images/');
    $today =new DateTime();
    $todayStr = $today->format('Y-m-d_H-i-s');
    $id = $_POST['facebook_id'];
	$img = $_POST['base64Img'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);	
	$file = UPLOAD_DIR . $id . '_' . $todayStr . '.png';
	$success = file_put_contents($file, $data);
	//print $success ? $file : 'Unable to save the file.';
	
	//insert data to db
	if($success){
		include 'connect-db.php';
		$todayStr = $today->format('Y-m-d H:i:s');
		$strSQL = "INSERT INTO receipts (facebook_id, receipt_date, picture)\n
		 VALUE ('".$id."', '".$todayStr."', '".$file."');";
		$result = $conn->query($strSQL);
		echo $result;		
		$conn->close();
	}
}
?>