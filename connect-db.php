<?php
/*$servername = "localhost";
$username = "root";
$password = "46671111";
$dbname = "minmin";*/
$servername = "localhost";
$username = "namningx_root_fake";
//$password = "c7Uq+y:6O9YKx7";
$password = "{JDEhx@S(m@(";
$dbname = "namningx_minmin_fake";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
echo "Connected successfully";
$conn->set_charset('utf8');

?>