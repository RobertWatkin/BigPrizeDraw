<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a href="#" class="navbar-left"><img style="width: 160px;" class="mr-2" src="images/LogoSmall.png" placeholder="Site Logo" alt=""></a>
  <!--<a class="navbar-brand" href="#" id="title">TITLE</a>-->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item w-sm-100 active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item w-sm-100">
        <a class="nav-link" href="contact.php">Contact Us</a>
      </li>

    </ul>
    <span class="navbar-text">
      <ul class="navbar-nav mr-auto">

        <?php
        //=========================
        //    IF NOT LOGGED IN
        //
        //=========================
        if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
          echo "
              <li class='nav-item w-sm-100'>
                  <a class='nav-link' href='member-signup.php'>Create Account</a>
              </li>
              <li class='nav-item'>
                  <a class='nav-link' href='member-login.php'>Login</a>
              </li>
              ";
        } else {
          //=========================
          //    IF LOGGED IN
          //
          //=========================
          // Gather num of items in basket
          $x = 0;
          if (isset($_SESSION['basket'])) {
            foreach ($_SESSION['basket'] as $id) {
              $x++;
            }
          }

          echo "
          <li class='dropdown'>
            <a href='#' class='dropdown-toggle nav-link' data-toggle='dropdown' role='button' aria-expanded='false'> 
              <span class='fa fa-gift bigicon'></span> " . $x . " - Items in Cart
              <span class='caret'></span>
            </a>
            <ul class='dropdown-menu dropdown-cart' style='width: 400px; max-height: 600px; overflow-y: scroll;' role='menu'>";
          $total = 0;
          // Display Items
          if (isset($_SESSION['basket'])) {
            // Gather data for tickets
            foreach ($_SESSION['basket'] as $id) {

              

              $query = "SELECT * FROM `tbltickets` WHERE ticketID=" . $id;
              $result = mysqli_query($conn, $query);

              $cid = 0;
              $cimg = "";
              $ctitle = "";
              $tnum = 0;

              while ($row = mysqli_fetch_array($result)) {
                $tnum = $row['ticketNumber'];
                $cid = $row['competitionID'];
              }

              $query = "SELECT * FROM `tblcompetitions` WHERE competitionID=" . $cid;
              $result = mysqli_query($conn, $query);

              while ($row = mysqli_fetch_array($result)) {
                $cimg = $row['image'];
                $ctitle = $row['title'];
                $cprice = $row['pricePerTicket'];

                $total += $cprice;

                // HTML for navbar basket
                echo "
                <li style='padding: 5px;'>
                <h6><b>" . $ctitle . "</b></h6>
                  
                  <div class='row justify-content-end' style='width: 100%;'>
                    <div class='col'>
                      <div class='box'>
                        <img src='" . $cimg . "' alt='comp image' style='height: 60px;' />
                      </div>
                    </div>
                    <div class='col'>
                      <div class='box'>
                        <p style='margin-bottom:0px;'>Number: <b>$tnum</b></p>
                        <p style='margin-bottom:0px;'>Price: <b>£$cprice</b></p>
                      </div>
                    </div>
                    <div class='col'>
                      <div class='box' style='padding: 10px; float: right;'>
                          <button class='btn btn-danger  fa fa-close'></button>
                      </div>
                    </div>
                  </div>
                  <hr>
                </li>
              ";
              }
            }
          } else {
            echo "<h6 style='padding: 5px;'> There are no items in your basket </h6><hr>";
          }
          echo "
            </p>Total: <b>£$total</b></p>
            <button class='btn btn-success' style='width: 30%; min-width: 100px; margin-left: 10px;'>Go To Cart</button>
            </ul>
          </li>
          ";



          //=========================
          //    IF ADMIN
          //
          //=========================
          if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]) {
            echo "
                <li class='nav-item w-sm-100'>
                  <a class='nav-link' href='admin.php'>Admin Area</a>
                </li>
                ";
          }

          echo " 
            <form method='post'>
                <li>
                    <button class='btn btn-danger' type='submit' name='Logout' value='logout' onclick='logout()'>Log Out</button>
                </li>
            </form>
            ";
        }
        ?>
      </ul>
    </span>
  </div>
</nav>