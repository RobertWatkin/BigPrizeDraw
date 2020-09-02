<!--  Created By Robert Watkin - RobertWatkin, GitHub
__________      ___.                  __     __      __         __   __   .__
\______   \ ____\_ |__   ____________/  |_  /  \    /  \_____ _/  |_|  | _|__| ____
 |       _//  _ \| __ \_/ __ \_  __ \   __\ \   \/\/   /\__  \\   __\  |/ /  |/    \
 |    |   (  <_> ) \_\ \  ___/|  | \/|  |    \        /  / __ \|  | |    <|  |   |  \
 |____|_  /\____/|___  /\___  >__|   |__|     \__/\  /  (____  /__| |__|_ \__|___|  /
-->

<?php

if (session_status() == PHP_SESSION_NONE) {
    //session has not started
    session_start();
};

// connects to the datbase
include("php/connection.php");

// logout code
include("php/logout.php");

include("php/upload-winner-images.php")

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
    <div class="container mt-2 mb-2 pt-1 p-3" style="border: 1px solid #000000; border-radius:12px; background-color: #ffffff;">
        <h1>Our Winners</h1>
        <?php
        // connects to the datbase
        include("php/connection.php");

        $query = "SELECT * FROM `winnerimages`";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {

            echo '
            <div class="card-columns" style="display: flex; flex-wrap: wrap; justify-content: center">';

            while ($row = mysqli_fetch_array($result)) {
                echo '                
                <div class="card card-default" style="flex: 0 0 auto; margin: 10px; border: 1px solid #505050; box-shadow: 10px 10px 5px grey;">
                    <img class="card-img" src="' . $row['imagePath'] . '" alt="Card image cap">
                </div>
                ';
            }
            echo "</div>";
        } else { ?>
            <div class="text-center">
                <h2>There are no winner images at the moment</h2>
            </div>
        <?php  }
        ?>



        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
            $id = $_SESSION["userID"];

            $query = "SELECT * FROM `tblusers` WHERE userID='$id' and isAdmin=1";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) { ?>
                <form <?php echo $_SERVER['PHP_SELF']; ?> method="post" name="signup" enctype="multipart/form-data">
                    <div class="form-group" data-children-count="1">
                        <i class="fa fa-picture-o" style="margin: 3px;"></i> Upload Winner Image
                        <input class="form-control-file" type="file" name="file">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-success btn-block btn-lg" name="Create Competition"></input>
                    </div>
                </form>
        <?php }
        }
        ?>


    </div>


    <!--Footer-->
    <?php include("php/footer.php"); ?>
</body>

</html>