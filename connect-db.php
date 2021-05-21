<?php
/*$servername = "localhost";
$username = "root";
$password = "46671111";
$dbname = "minmin";*/
$servername = "localhost";
$username = "namningx_root";
$password = "{JDEhx@S(m@(";
$dbname = "namningx_minmin";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8');

?>