<?php include_once 'header.php'; ?>
    <div class='container'>
        <?php if (login_check($pdo) == true) : ?>
            <h3>Combat Summary for <?php echo $_SESSION['username']; ?></h3>
                <?php

                    // get recent combat
                    $stmt = $pdo->prepare("SELECT c.*, a.username as attacker, d.username as defender
                                           FROM combat AS c
                                           JOIN members AS d ON d.id = c.defender_id
                                           JOIN members AS a ON a.id = c.attacker_id
                                           WHERE (c.attacker_id = :user_id OR c.defender_id = :user_id) AND c.`timestamp` BETWEEN DATE(adddate(now(),interval -30 day)) AND NOW()
                                           ORDER BY c.`timestamp`");
                    $stmt->execute(array(':user_id' => $_SESSION['user_id']));
                    if ($stmt->rowcount() > 0) {
                        while ($row = $stmt->fetch()) {
                            echo 'Attacker: '.$row['attacker'] . '<br />Defender: ' . $row['defender'] . "\n";
                        }
                    } else {
                        echo 'No combat in the last 30 days';
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