<?php include_once 'header.php'; ?>
    <div class='container'>
        <?php if (login_check($pdo) == true) : ?>
                <h3>Outbox</h3>
            <?php

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $insert_stmt = $pdo->prepare("UPDATE messages
                                      SET sent_deleted = 1
                                      WHERE id = ?");
        if (! $insert_stmt->execute(array($value))) {
            header('Location: ../error.php?err=Delete message failure: UPDATE');
        }
    }
    echo 'Messages Deleted successfully.<br />';
}


              $stmt = $pdo->prepare("SELECT ms.id, m.username, ms.subject, ms.timestamp
                                     FROM messages as ms
                                     JOIN members as m on m.id = ms.to_user
                                     WHERE ms.from_user = ? AND ms.sent_deleted <> 1
                                     ORDER BY ms.`timestamp` DESC");
              $stmt->execute(array($_SESSION['user_id']));
              if($stmt->rowcount() > 0) {
                ?>
                <form role="delete email" action="outbox.php" method="post">
                <?php
                $i = 0;
                while($row = $stmt->fetch()) {
                  ?>
                  <dl class='dl-horizontal'>
                    <dt><?php echo $row['timestamp']; ?></dt>
                    <dd><?php echo $row['username']; ?></dd>
                    <dd><a href="message.php?m_id=<?php echo $row['id']; ?>"><?php echo $row['subject']; ?></a></dd>
                    <input type="checkbox" name="email_id<?php echo $i ?>" id="email_id<?php echo $i ?>" value=<?php echo $row['id']; ?> />
                  </dl>
                  <?php
                  $i++;
                }
                ?>
                <button type="submit" value="Delete Email">Delete Selected Email</button>
                </form>
                <?php
              } else {
                echo 'No messages to display';
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