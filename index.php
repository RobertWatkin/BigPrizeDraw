<!--  Created By Robert Watkin - RobertWatkin, GitHub
__________      ___.                  __     __      __         __   __   .__
\______   \ ____\_ |__   ____________/  |_  /  \    /  \_____ _/  |_|  | _|__| ____
 |       _//  _ \| __ \_/ __ \_  __ \   __\ \   \/\/   /\__  \\   __\  |/ /  |/    \
 |    |   (  <_> ) \_\ \  ___/|  | \/|  |    \        /  / __ \|  | |    <|  |   |  \
 |____|_  /\____/|___  /\___  >__|   |__|     \__/\  /  (____  /__| |__|_ \__|___|  /
-->

<?php
// Initialize the session
session_start();

// Connect to Database
include("php/connection.php");

// logout code
include("php/logout.php");

// display comps
include("php/dynamic-table.php");
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

  <!-- Content section -->
  <div class="container mt-2 mb-2 pt-1 p-3" style="border: 1px solid #000000; border-radius: 12px; background-color: #ffffff;">
    <div>
      <h1>Top Competitions</h1>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="competitionImages\5f1d8e18b6af08.04699740.jpg" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="competitionImages\5f1d8e18b6af08.04699740.jpg" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="competitionImages\5f1d8e18b6af08.04699740.jpg" alt="Third slide">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <hr>
    <div class="container">
      <h1>How to Enter</h1>
      <div class="card-deck text-center">
        <div class="card p-2">
          <h2 class="card-title">Step 1</h2>
          <div style="height: 100px;">
            <h5 class="p-2">Pick any competition and select your Winning ticket! You can even select multiple tickets.</h5>
          </div>
          <i class="fa fa-ticket p-2" style="font-size: 64px;" aria-hidden="true"></i>
        </div>
        <div class="card p-2">
          <h2 class="card-title">Step 2</h2>
          <div style="height: 100px;">
            <h5 class="p-2">Head over to the checkout to purchase your selected tickets.</h5>
          </div>
          <i class="fa fa-money p-2" style="font-size: 64px;" aria-hidden="true"></i>
        </div>
        <div class="card p-2">
          <h2 class="card-title">Step 3</h2>
          <div style="height: 100px;">
            <h5 class="p-2">Watch our streams live from FaceBook to find out if you have won.</h5>
          </div>
          <i class="fa fa-trophy p-2" style="font-size: 64px;" aria-hidden="true"></i>
        </div>
      </div>
      <hr>

      <!-- Content section -->
      <div class="container">
        <h1>All Competitions</h1>
        <?php echo $dyn_table; ?>
      </div>
    </div>

    
  </div>

  


  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>