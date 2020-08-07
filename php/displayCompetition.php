<?php
$comp = $row = mysqli_fetch_array($result);
$title = $comp['title'];
$desc = $comp['description'];
$price = $comp['pricePerTicket'];
$numTickets = $comp['numberOfTickets'];
$image = $comp['image'];
$date = $comp['drawDate'];
$isActive = $comp['isActive'];
?>

<?php echo "
<h1>$title</h1>
<img class='mb-5' src='$image' alt='Competition Image' style='width:100%;' />
<div class='text-center'>
    <h4>$desc</h4>
    <h6>£$price per ticket, there are $numTickets available for this competition</h6>
</div>
<h2>Select Your Ticket</h2>
";

$query = "SELECT * FROM `tbltickets` WHERE competitionID=".$_GET['comp'];
$result = mysqli_query($conn, $query);


echo "
<form method='post'>

<div style='display: flex; flex-wrap: wrap; justify-content: flex-start; padding: 10px;'>
";
while ($row = mysqli_fetch_array($result)){
    if ($row['available'] == 1){
        echo "
        <div class='formrow'>
            <input type='checkbox' class='checkbox' name='tickets[]' value='".$row['ticketNumber']."'>
            <label class='checklabel' style='color: white;' for='".$row['ticketNumber']."'>".$row['ticketNumber']."</label>
        </div>";
    } else {
        echo "
        <button disabled style='width: 60px; height: 60px; opacity: 0.5; background-color: #000000; display: flex; justify-content: center; align-items: center; border: 0px solid #000000; border-radius: 6px; margin: 5px; cursor: default;'>
            <div style='color: white;'>"
        .$row['ticketNumber'].
            "</div>
        </button>";
    }
}
echo "</div>
<input id='submitButton' class='btn btn-success center' type='submit' name='submit' value='To Cart' />
</form>";


?>

