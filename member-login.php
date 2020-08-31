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

if (isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] == "true")) {
    header("Location: index.php");
}


// Connect to Database
include("php/connection.php");

// logout code
include("php/logout.php");

// login code
include("php/login.php");
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
    <div style="display: block; height: 60vh; min-height: 350px;" aria-modal="true">
        <div class="modal-dialog modal-login" style="margin-top: 4%; box-shadow: 10px 10px 5px grey;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Member Login</h4>
                </div>


                <!-- /\/\/\/\/\/
            \/\/ MAIN LOGIN FORM
            /\/\/\/\/\/\/\/\-->

                <div class="modal-body">
                    <form <?php echo $_SERVER['PHP_SELF']; ?> method="post" name="login">
                        <?php
                        // displays error message to the user
                        if (isset($errorMessage) && strlen($errorMessage) != 0) {
                            echo "
                        <div style='border-radius: 5px; color: #ffffff; background-color: #f05050;'>
                            <i class='fa fa-ban' style='float: right; margin: 6px;'></i>
                            <p style='padding: 3px;'>$errorMessage</p>
                        </div>
                        ";
                        }
                        ?>
                        <div class="form-group" data-children-count="1">
                            <i class="fa fa-user" style="margin: 3px;"></i>
                            <input type="email" class="form-control" placeholder="Email" required="required" name="Email">
                        </div>
                        <div class="form-group" data-children-count="1">
                            <i class="fa fa-lock" style="margin: 3px;"></i>
                            <input type="password" class="form-control" placeholder="Password" required="required" name="Password">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>


    <!--Footer-->
    <?php include("php/footer.php"); ?>
</body>

</html>