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
    <div style="display: block; height: 60vh; min-height: 700px;" aria-modal="true">
        <div class="modal-dialog modal-login" style="margin-top: 4%; box-shadow: 10px 10px 5px grey;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reset Password</h4>
                </div>


                <!-- /\/\/\/\/\/
            \/\/ MAIN Signup FORM
            /\/\/\/\/\/\/\/\-->

                <div class="modal-body">
                        <?php
                        if (isset($_GET["selector"]) && isset($_GET["validator"])){
                            $selector = $_GET["selector"];
                            $validator = $_GET["validator"];
                        }

                        if (empty($selector) || empty($validator)) {
                            echo "Could not validate your request!";
                        } else {
                            if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                        ?>
                                <form action="php/reset-password.inc.php" method="post">
                                    <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                                    <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                                    <input type="password" class="form-control" name="pwd" placeholder="Enter a new password...">
                                    <input type="password" class="form-control" name="pwd-repeat" placeholder="Repeat new password...">
                                    <button type="submit" name="submit">Reset Password</button>
                                </form>
                        <?php
                            }
                        }?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Footer-->
    <?php include("php/footer.php"); ?>
</body>

</html>