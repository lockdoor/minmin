<?php
$servername = "localhost";
$username = "root";
$password = "46671111";
$dbname = "minmin";
$conn = new mysqli($servername, $username, $password, $dbname) or die ('Connection failed');
$conn->set_charset('utf8');
?>