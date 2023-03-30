<?php 
$connect = mysqli_connect('localhost', 'root', '', 'payment_system');


// Check connection
if($connect === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>