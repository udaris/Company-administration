<?php
if(isset($_GET["id"])){

    $id=$_GET["id"];
    $servername="localhost";
    $username="root";
    $password="1234567";
    $database="php_dev_udari";

    //create connection
$connection=new mysqli($servername, $username, $password, $database);

$sql="DELETE FROM members WHERE ID=$id";
$connection->query($sql);

}
header("location:/udari/index.php?m=1");
exit;
?>