<?php include_once 'header.php'; ?>
    <div class='container'>
        <?php if (login_check($pdo) == true) : ?>
                <h3>Send a Message</h3>

                <form class="form-horizontal" role="form" action="send_message.php" method="post" name="send_message">
                  <div class="form-group">
                    <label for="to_user" class="col-sm-2 control-label">To:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="to_user" name="to_user" placeholder="Enter a Username">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="subject" class="col-sm-2 control-label">Subject:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="message" class="col-sm-2 control-label">Message:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="message" name="message" placeholder="Type your message...">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4">
                      <button type="submit" class="btn btn-default" value="Send">Send Message</button>
                    </div>
                  </div>
                </form>

        <?php
              if (!empty($_POST)) {
                $stmt = $pdo->prepare("SELECT m.id FROM members AS m WHERE m.username = ? LIMIT 1");
                $stmt->execute(array($_POST['to_user']));
                $row = $stmt->fetch();
                $to_user = $row['id'];
                $from_user = $_SESSION['user_id'];

                $insert_stmt = $pdo->prepare("INSERT INTO messages (from_user, to_user, subject, message)
                                              VALUES (?, ?, ?, ?)");
                if($insert_stmt->execute(array($from_user,$to_user,$_POST['subject'],$_POST['message']))) {
                  echo 'Message sent successfully';
                } else {
                  echo 'Error sending message.';
                }

        }
        ?>

            <p>Return to <a href="login.php">login page</a></p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.
            </p>
        <?php endif; ?>
    </div>
    </body>
</html>