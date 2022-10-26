<?php

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

$conn = mysqli_connect('localhost', 'root', '', 'asikislam') or die("Connection Successfully");

$insertData = " INSERT INTO `info`(`fname`, `lname`) VALUES ('$first_name','$last_name') ";

$result = mysqli_query($conn, $insertData);

if($result === TRUE){
    echo 1;
}else{
    0;
}

?>