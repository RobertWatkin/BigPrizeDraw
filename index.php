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

<body>
  <!--Navbar-->
  <?php include("php/navbar.php"); ?>

  <!--Main-->
  <!-- Header - set the background image for the header in the line below -->
  <header class="py-5 bg-image-full" style="background-image: url('images/lotto-balls.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;">
    <img class="img-fluid d-block mx-auto" style="height: 150px;" src="" alt="">
  </header>

  <!-- Content section -->
  <section class="py-5">
    <div class="container">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active">
            <img src="competitionImages/5f1d8e18b6af08.04699740.jpg" alt="Los Angeles">
          </div>

          <div class="item">
            <img src="competitionImages/5f1d8e18b6af08.04699740.jpg" alt="Chicago">
          </div>

          <div class="item">
            <img src="competitionImages/5f1d8e18b6af08.04699740.jpg" alt="New York">
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </section>

  <!-- Content section -->
  <section class="py-5">
    <div class="container">
      <h1>Our Competitions</h1>
      <?php echo $dyn_table; ?>
    </div>
    </div>
  </section>

  <hr>

  <!-- Image element - set the background image for the header in the line below -->
  <div class="py-5 bg-image-full" style="background-image: url('images/red_car.jpg');  background-repeat: no-repeat; background-size: cover; background-position: center;"">
    
  </div>

  


  <!--Footer-->
  <?php include("php/footer.php"); ?>
</body>

</html>