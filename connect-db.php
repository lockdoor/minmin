<?php
/*$servername = "localhost";
$username = "root";
$password = "46671111";
$dbname = "minmin";*/
$servername = "localhost_";
$username = "namningx_root";
//$password = "c7Uq+y:6O9YKx7";
$password = "{JDEhx@S(m@(";
$dbname = "namningx_minmin";
$conn = new mysqli($servername, $username, $password, $dbname) or die ('Connection failed');
$conn->set_charset('utf8');
print $conn ? 'connect success' : 'Connection failed';
?>