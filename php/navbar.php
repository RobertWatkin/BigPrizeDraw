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
          if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]){
              echo "
              <li class='nav-item w-sm-100'>
                  <a class='nav-link' href='member-signup.php'>Create Account</a>
              </li>
              <li class='nav-item'>
                  <a class='nav-link' href='member-login.php'>Login</a>
              </li>
              ";

          } else {

            if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]){
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