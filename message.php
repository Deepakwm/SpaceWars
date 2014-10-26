<?php include_once 'header.php'; ?>
<?php if(isset($_GET['m_id'])) $m_id = $_GET['m_id'];
      else $m_id = ''; ?>
    <div class='container'>
        <?php if (login_check($pdo) == true) : ?>
                <h3>Message</h3>
            <?php
              $stmt = $pdo->prepare("SELECT ms.id, f.username as fuser, t.username as tuser, ms.subject, ms.timestamp, ms.message
                                     FROM messages as ms
                                     JOIN members as f on f.id = ms.from_user
                                     JOIN members as t on t.id = ms.to_user
                                     WHERE ms.id = :m_id AND (ms.from_user = :user_id OR ms.to_user = :user_id)
                                     LIMIT 1");
              $stmt->execute(array(':m_id' => $m_id, ':user_id' => $_SESSION['user_id']));
              if($stmt->rowcount() > 0) {
                while($row = $stmt->fetch()) {
                  ?>
                  <dl class='dl-horizontal'>
                    <dt><?php echo $row['timestamp']; ?></dt>
                    <dd>From: <?php echo $row['fuser']; ?></dd>
                    <dd>To: <?php echo $row['tuser']; ?></dd>
                    <dd>Subject: <?php echo $row['subject']; ?></a></dd>
                    <dd><?php echo $row['message']; ?></dd>
                  </dl>
                  <?php
                }
              } else {
                echo 'No message to display';
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