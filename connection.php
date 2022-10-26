<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$db_name = 'asikislam';

$conn = mysqli_connect($servername, $username, $password, $db_name);

if($conn){
    ?>
<script>
alert("Connection Successfully");
</script>
<?php
}else{
    echo "Not connection!";
}