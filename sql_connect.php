<?php
//phpinfo();
$userName = "root";
$userPass = "7ygvcft6";

////MySQL
$serverName = "localhost"; 
$conn=null;

/* check connection */ 
if (!$conn) {
    // Create connection
    $conn = mysqli_connect($serverName, $userName, $userPass,"warehousebm");
    //printf("Connect failed: %s\n", mysqli_connect_error());
    //exit();
}



?>