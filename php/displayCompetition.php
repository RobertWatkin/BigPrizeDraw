<?php


$comp = $row = mysqli_fetch_array($result);
$title = $comp['title'];
$desc = $comp['description'];
$price = $comp['pricePerTicket'];
$numTickets = $comp['numberOfTickets'];
$image = $comp['image'];
$date = $comp['drawDate'];
$isActive = $comp['isActive'];

// Handles button presses for the site
if ($_SERVER["REQUEST_METHOD"] == "POST"){

  if (!empty($_POST["selectedTickets"])){
    foreach($_POST["selectedTickets"] as $ticketID){
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = array();
        }
        $key=array_search($ticketID,$_SESSION['basket']);
        if($key==false)
            array_push($_SESSION["basket"],$ticketID);
    }
  }
}
?>

<?php echo "

<h1>$title</h1>
<div class='row'>
    <div class='col-xs-12 col-md-6'>
        <img class='mb-5' src='$image' alt='Competition Image' style='border-radius: 7px; width: 100%;' />
    </div>

    <div class='col-xs-12 col-md-6' padding: 50px;'>
        <h5>Countdown</h5>
        <div class='row text-center'>
            <div class='col-3'>
                <h4 id='dn'></h4>
                <p >DAYS</p>
            </div>
            <div class='col-3'>
                <h4 id='hn'></h4>
                <p >HOURS</p>
            </div>
            <div class='col-3'>
                <h4 id='mn'></h4>
                <p >MINUTES</p>
            </div>
            <div class='col-3'>
                <h4 id='sn'></h4>
                <p >SECONDS</p>
            </div>
        </div>
        <hr>
        <h5 class='mt-4 mb-4'>$desc</h5>
        <h5 class='text-center'><b>£$price</b> per ticket</h5>
        <p class='mt-4'>To enter this competition select your tickets below. Your tickets will be added to your cart so you can continue to browse our other competitions</p>
    </div>
</div>
<h2>Select Your Tickets</h2>
";

$query = "SELECT * FROM `tbltickets` WHERE competitionID=" . $_GET['comp'];
$result = mysqli_query($conn, $query);


echo "
<hr>
<form method='post'>
<div class='' data-toggle='buttons' style='display: flex; flex-wrap: wrap; justify-content: flex-start; padding: 10px;'>
";
while ($row = mysqli_fetch_array($result)) {
    if ($row['available'] < date('Y-m-d H:i:s')) {
        echo " 
        <label class='btn btn-success' style='margin: 3px; width: 50px; height: 50px;'>
            <input type='checkbox' name='selectedTickets[]' value='". $row['ticketID'] . "' style='display:none; padding: auto;'><b>" . $row['ticketNumber'] . "</b>
        </label>";
    } else {
        echo "
        <label class='btn btn-info' style='opacity: 0.8; margin: 3px; width: 50px; height: 50px;' disabled>
            <input type='checkbox' name='invalid[]' value='" . $row['ticketID'] . "' style='display:none; padding: auto;' disabled><b>" . $row['ticketNumber'] . "</b>
        </label>";
    }
}
echo "</div>
<input id='submitButton' class='btn btn-success center' type='submit' name='submit' value='Add To Cart' />
</form>";


?>

<script>
    // Set the date we're counting down to
    var countDownDate = new Date("<?php echo $date; ?>").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);



        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            var days = 0;
            var hours = 0;
            var minutes = 0;
            var seconds = 0;
        }

        // Display the countdowm
        document.getElementById("dn").innerHTML = days;
        document.getElementById("hn").innerHTML = hours;
        document.getElementById("mn").innerHTML = minutes;
        document.getElementById("sn").innerHTML = seconds;


    }, 1000);
</script>