<?php

$id = $_POST['id'];

$conn = mysqli_connect('localhost', 'root', '', 'asikislam') or die("Connection Successfully");

$insertData = " DELETE FROM `info` WHERE Id = $id ";

$result = mysqli_query($conn, $insertData);

if($result === TRUE){
    echo 1;
}else{
    0;
}

?>