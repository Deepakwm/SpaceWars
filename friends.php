<?php include_once 'header.php'; ?>
    <div class='container'>
        <?php if (login_check($pdo) == true) : ?>
            <h1><?php echo htmlentities($_SESSION['username']); ?>'s Friends</h1>

                <h3>Pending Requests</h3>

                <?php

                    $sql = 'SELECT f.member_id, m.username, c.name as clan
                            FROM friends as f
                            JOIN members as m on m.id = f.member_id
                            JOIN clans as c on c.id = m.clan_id
                            WHERE f.friend_id =' . $_SESSION['user_id'] . ' AND f.accepted = 0';

                    if ($result = $pdo->query($sql)) {

                        /* fetch object array */
                        while ($row = $result->fetch()) { ?>

                            <dt><a href="user.php?user=<?php echo $row['member_id']; ?>"><?php echo $row['username']; ?></a></dt>
                            <dt><?php echo $row['clan']; ?></dt>
                            <dt>Accept Friendship</dt>

                        <?php

                        }
                    }


                    $sql = 'SELECT f.friend_id, m.username, c.name as clan
                            FROM friends as f
                            JOIN members as m on m.id = f.friend_id
                            JOIN clans as c on c.id = m.clan_id
                            WHERE f.member_id =' . $_SESSION['user_id'] . ' AND f.accepted = 0';

                    if ($result = $pdo->query($sql)) {

                        /* fetch object array */
                        while ($row = $result->fetch()) { ?>

                            <dt><a href="user.php?user=<?php echo $row['friend_id']; ?>"><?php echo $row['username']; ?></a></dt>
                            <dt><?php echo $row['clan']; ?></dt>

                        <?php

                        }
                    }

                ?>

                <h3>Friends</h3>

                <?php

                $sql = 'SELECT f.friend, m.username, f.`timestamp`, f.accepted, c.name as clan FROM (
                            SELECT member_id as friend, `timestamp`, accepted
                            FROM friends
                            WHERE friend_id = ' . $_SESSION['user_id'] . '
                            UNION ALL
                            SELECT friend_id as friend, `timestamp`, accepted
                            FROM friends
                            WHERE member_id = ' . $_SESSION['user_id'] . '
                        ) as f
                        JOIN members as m on m.id = f.friend
                        JOIN clans as c on c.id = m.clan_id
                        WHERE f.accepted = 1
                        ORDER BY m.username';

                    if ($result = $pdo->query($sql)) {

                        /* fetch object array */
                        while ($row = $result->fetch()) { ?>

                            <dt><a href="user.php?user=<?php echo $row['friend']; ?>"><?php echo $row['username']; ?></a></dt>
                            <dt><?php echo $row['clan']; ?></dt>
                            <?php $friend_start = date_create($row['timestamp']); ?>
                            <dt><?php echo $friend_start->format('F jS, Y'); ?></dt>

                        <?php

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