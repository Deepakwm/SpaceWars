<?php include_once 'header.php'; ?>
<div class="container">
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?>
        <?php if (login_check($pdo) == true) : ?>
          <h3>You are currently logged in as <a href="profile.php"><?php echo htmlentities($_SESSION['username']) ?></a></h3>
          <h4><small>Not you? <a href="includes/logout.php">Logout</a></small></h4>
        <?php else : ?>
        <form class="form-horizontal" role="form" action="includes/process_login.php" method="post" name="main_login">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-4">
              <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-4">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
              <button type="submit" class="btn btn-default" value="Login" onclick="formhash(this.form, this.form.password);">Log in</button>
            </div>
          </div>
        </form>

        <p>If you don't have a login, please <a href="register.php">register</a>.</p>
        <?php endif; ?>
</div>
    </body>
</html>