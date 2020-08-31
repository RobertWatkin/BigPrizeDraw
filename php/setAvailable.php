<?php
if (session_status() == PHP_SESSION_NONE) {
    //session has not started
    session_start();
  };
// connects to the datbase
include("connection.php");

$date = new DateTime();
$date->modify("-5 minutes");
$result = $date->format('Y-m-d H:i:s');

foreach ($_SESSION['basket'] as $id) {

  $query = "SELECT * FROM `tbltickets` WHERE ticketID='$id'";
  $run = mysqli_query($conn, $query);

  $ticket = mysqli_fetch_array($run);

  if ($ticket['userID'] == $_SESSION['userID']){
    $query = "UPDATE `tbltickets` SET available='$result' WHERE ticketID='$id'";
    $run = mysqli_query($conn, $query);
  }
}
