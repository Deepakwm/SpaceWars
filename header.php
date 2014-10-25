<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Profile</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="        #bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="main.php">Game</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Main <span class="caret">      </span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="friends.php">Friends</a></li>
                    <li><a href="#">Guild</a></li>
                    <li><a href="#">User Search</a></li>
                    <li><a href="#">Messages</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Preferences</a></li>
                    <li><a href="includes/logout.php">Logout</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Clan <span class="caret">      </span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Overview</a></li>
                    <li><a href="#">Upgrades</a></li>
                    <li><a href="#">Recruit</a></li>
                  </ul>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Resources <span class="caret">      </span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Overview</a></li>
                    <li><a href="#">Upgrades</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Combat <span class="caret">      </span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Summary</a></li>
                    <li><a href="#">Attack!</a></li>
                    <li><a href="#">Security</a></li>
                  </ul>
                </li>
              </ul>
              <?php if (login_check($pdo) == true) : ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="includes/logout.php">Logout</a></li>
                </ul>
                <p class="navbar-text navbar-right">Signed in as <a href="profile.php" class="navbar-link"><?php echo htmlentities($_SESSION['username']); ?></a></p>
              <?php else : ?>
                <form class="navbar-form navbar-right" role="login" action="includes/process_login.php" method="post" name="login_form">
                  <div class="form-group">
                    <div class="input-group input-group-sm">
                      <input class="form-control" type="text" name="email" placeholder="email">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-sm">
                      <input type="password" name="password" class="form-control" id="password" placeholder="password">
                    </div>
                  </div>
                  <button type="button" class="btn btn-default" value="Login" onclick="formhash(this.form, this.form.password);">Log in</button>
                </form>
              <?php endif; ?>

            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>