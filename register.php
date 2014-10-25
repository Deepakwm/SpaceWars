<?php include_once 'includes/register.inc.php'; ?>
<?php include_once 'header.php'; ?>
<div class="container">

        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Register with us</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>

        <?php if (login_check($pdo) == true) : ?>
          <h3>You are currently logged in as <a href="profile.php"><?php echo htmlentities($_SESSION['username']) ?></a></h3>
          <h4><small>Not you? <a href="includes/logout.php">Logout</a></small></h4>
        <?php else : ?>
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
            <li>Emails must have a valid email format</li>
            <li>Passwords must be at least 6 characters long</li>
            <li>Passwords must contain
                <ul>
                    <li>At least one upper case letter (A..Z)</li>
                    <li>At least one lower case letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </li>
            <li>Your password and confirmation must match exactly</li>
        </ul>

        <form class="form-horizontal" role="register" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form1">
          <div class="form-group">
            <label for="firstName" class="col-sm-2 control-label">First Name</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="forename" name="forename" placeholder="First Name">
            </div>
          </div>
          <div class="form-group">
            <label for="firstName" class="col-sm-2 control-label">Last Name</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="surname" name="surname" placeholder="Last Name">
            </div>
          </div>
          <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
          </div>
          <div class="form-group">
            <label for="gender" class="col-sm-2 control-label">Gender</label>
            <label class="radio-inline">
              <input type="radio" name="gender" id="gender1" value="1"> Male
            </label>
            <label class="radio-inline">
              <input type="radio" name="gender" id="gender2" value="2"> Female
            </label>
            <label class="radio-inline">
              <input type="radio" name="gender" id="gender3" value="3"> Other
            </label>
          </div>
          <div class="form-group">
            <label for="birthday" class="col-sm-2 control-label">Birthday</label>
            <div class="col-sm-4">
              <input type="date" class="form-control" id="birthday" name="birthday">
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-4">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-4">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
          </div>
          <div class="form-group">
            <label for="confirmpwd" class="col-sm-2 control-label">Confirm Password</label>
            <div class="col-sm-4">
              <input type="password" class="form-control" id="confirmpwd" name="confirmpwd" placeholder="Corfirm Passord">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
              <button type="submit" class="btn btn-default" value="Register"
                onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd,
                                   this.form.forename,
                                   this.form.surname,
                                   this.form.gender,
                                   this.form.birthday);">Sign up</button>
            </div>
          </div>
        </form>
        <?php endif; ?>
        <p>Return to the <a href="login.php">login page</a>.</p>
</div>
    </body>
</html>