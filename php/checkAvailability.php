<?php
if (session_status() == PHP_SESSION_NONE) {
    //session has not started
    session_start();
};


$tickets = "";
$ticketIDs = array();

foreach ($_SESSION['basket'] as $id) {
    $query = "SELECT * FROM `tbltickets` WHERE ticketID='$id'";
    $run = mysqli_query($conn, $query);

    $result = mysqli_fetch_array($run);


    if (date('Y-m-d H:i:s') < $result['available']) {
        if ($result['userID'] != $_SESSION['userID']) {
            $tickets .= $result['ticketNumber'] . " ";
            array_push($ticketIDs, $id);
        }
    }
}

echo $tickets;
