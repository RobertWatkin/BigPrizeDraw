<?php
include("php/connection.php");

$date = new DateTime();
$date->modify("+10 minutes");
foreach ($_SESSION['basket'] as $id){
  
  $query = "UPDATE `tbltickets` SET available=$date  WHERE ticketID=$id";
  $result = mysqli_query($conn, $query);
}

echo "success";
?>