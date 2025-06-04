<?php
$host = "localhost";
$db = "streaming";  
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_errno!=0){
    echo "Error:".$conn->connect_errno;
    exit;
}

?>