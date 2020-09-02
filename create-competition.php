<!--  Created By Robert Watkin - RobertWatkin, GitHub
__________      ___.                  __     __      __         __   __   .__
\______   \ ____\_ |__   ____________/  |_  /  \    /  \_____ _/  |_|  | _|__| ____
 |       _//  _ \| __ \_/ __ \_  __ \   __\ \   \/\/   /\__  \\   __\  |/ /  |/    \
 |    |   (  <_> ) \_\ \  ___/|  | \/|  |    \        /  / __ \|  | |    <|  |   |  \
 |____|_  /\____/|___  /\___  >__|   |__|     \__/\  /  (____  /__| |__|_ \__|___|  /
-->

<?php
// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
  //session has not started
  session_start();
};

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
  header("Location: index.php");
}

// connects to the datbase
include("php/connection.php");

// Double check that the user has admin access
$id = $_SESSION["userID"];

$query = "SELECT * FROM `tblusers` WHERE userID='$id' and isAdmin=1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) < 1) {
  header("Location: index.php");
}

// logout code
include("php/logout.php");

// create competition code
include("php/new-comp.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("php/head.php"); ?>
</head>

<body class="main">

  <!--Navbar-->
  <?php include("php/navbar.php"); ?>

  <!--Main-->
  <div class="container mt-5 mb-5" style="border: 1px solid #000000; border-radius: 12px; background-color: #ffffff;  box-shadow: 10px 10px 5px grey;">

    <h1>New Competition</h1>
    <form <?php echo $_SERVER['PHP_SELF']; ?> method="post" name="signup" enctype="multipart/form-data">

      <div class="form-group" data-children-count="1">
        <i class="fa fa-gift" style="margin: 3px;"></i>
        <input type="text" class="form-control" placeholder="Competition Name / Prize" required="required" name="title" />
      </div>

      <div class="form-group" data-children-count="1">
        <i class="fa fa-gift" style="margin: 3px;"></i>
        <input type="text" class="form-control" placeholder="Short Description" required="required" name="description" />
      </div>

      <div class="form-group" data-children-count="1">
        <i class="fa fa-ticket" style="margin: 3px;"></i>
        <input type="number" class="form-control" placeholder="Number of Tickets" min="1" step="1" name="numTickets" />
      </div>

      <div class="form-group" data-children-count="1">
        <i class="fa fa-gbp" style="margin: 3px;"></i>
        <input type="number" class="form-control" placeholder="Price per ticket - e.g 2.50" min="0.50" step="0.01" name="price" />
      </div>

      <div class="form-group" data-children-count="1">
        <i class="fa fa-picture-o" style="margin: 3px;"></i> Competition Image
        <input class="form-control-file" type="file" name="file">
      </div>


      <div class="form-group" data-children-count="1">
        <i class="fa fa-calendar" style="margin: 3px;"></i> Competition Draw Date
        <br>
        <input type="datetime-local" id="drawdate" name="drawDate">
      </div>

      <div class="form-group" data-children-count="1">
        <i class="fa fa-question-circle" style="margin: 3px;"></i> Competition Question
        <br>
        <input type="text" class="form-control mb-2" placeholder="Question..." required="required" name="q" />
        <input type="text" class="form-control" placeholder="Correct Answer..." required="required" name="correct-answer" />
        <input type="text" class="form-control" placeholder="Incorrect Answer 1..." required="required" name="incorrect-answer-one" />
        <input type="text" class="form-control" placeholder="Incorrect Answer 2..." required="required" name="incorrect-answer-two" />
      </div>



      <div class="form-group">
        <input type="submit" class="btn btn-success btn-block btn-lg" name="Create Competition"></input>
      </div>
    </form>
  </div>



  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>