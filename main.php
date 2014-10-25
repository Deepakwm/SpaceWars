<?php include_once 'header.php'; ?>
    <div class='container'>
        <?php if (login_check($pdo) == true) : ?>
            <h1>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h1>
                <?php
                    $sql = 'SELECT *
                            FROM combat
                            WHERE (attacker_id =' . $_SESSION['user_id'] . 'OR defender_id =' . $_SESSION['user_id'] . ') AND `timestamp` BETWEEN DATE(adddate(now(),interval -1 day)) AND NOW()
                            ORDER BY `timestamp`';

                    if ($result = $pdo->query($sql)) {

                        /* fetch object array */
                        while ($row = $result->fetch()) {

                        }
                        /* free result set */
                        $result->close();
                    }
                    else {
                        echo 'No recent combat';
                    }
                    $sql = 'SELECT r.*, c.name
                        FROM resources AS r
                        JOIN members AS m ON m.id = r.member_id
                        JOIN clans AS c ON c.id = m.clan_id
                        WHERE member_id =' . $_SESSION['user_id'];

                    if ($result = $pdo->query($sql)) {

                        /* fetch object array */
                        while ($row = $result->fetch()) { ?>

                            <h3>Clan Information</h3>
                            <dl class='dl-horizontal'>
                                <dt>Name:</dt><dd><?php echo $row['name']; ?> </dd>
                                <dt>Credits:</dt><dd><?php echo $row['credits']; ?></dd>
                                <dt>Income Rate:</dt><dd><?php echo $row['income_rate']; ?></dd>
                                <dt>Energy:</dt><dd><?php echo $row['energy']; ?></dd>
                                <dt>Energy Refill Rate:</dt><dd><?php echo $row['energy_rate']; ?></dd>
                                <dt>Units:</dt><dd><?php echo $row['units']; ?></dd>
                                <dt>Recruitment Rate:</dt><dd><?php echo $row['recruit_rate']; ?></dd>
                                <dt>Attack:</dt><dd><?php echo $row['base_attack']; ?></dd>
                                <dt>Defense:</dt><dd><?php echo $row['base_defense']; ?></dd>
                                <dt>Tech Level:</dt><dd><?php echo $row['tech_level']; ?></dd>
                                <dt>Influence:</dt><dd><?php echo $row['influence']; ?></dd>
                            </dl>

                            <?php
                        }
                    }
                    else {
                        echo 'No Clan Selected';
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