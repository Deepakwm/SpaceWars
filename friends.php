<?php include_once 'header.php'; ?>
    <div class='container'>
        <?php if (login_check($pdo) == true) : ?>
            <h1><?php echo htmlentities($_SESSION['username']); ?>'s Friends</h1>

                <h3>Pending Requests</h3>


                <?php
                //incoming requests
                    $requests = 0;
                    $stmt = $pdo->prepare("SELECT f.id, f.member_id, m.username, c.name as clan
                                           FROM friends as f
                                           JOIN members as m on m.id = f.member_id
                                           JOIN clans as c on c.id = m.clan_id
                                           WHERE f.friend_id = ? AND f.accepted = 0");
                    $stmt->execute(array($_SESSION['user_id']));
                    if ($stmt->rowcount() > 0) {
                        //pending incoming requests
                        ?>
                        <form role="addfriend" action="includes/add_friend.php" method="post">
                        <?php
                        $i = 1;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <dt><a href="user.php?user=<?php echo $row['member_id']; ?>"><?php echo $row['username']; ?></a></dt>
                            <dt><?php echo $row['clan']; ?></dt>
                            <dt><input type="checkbox" name="friend_id<?php echo $i ?>" id="friend_id<?php echo $i ?>" value=<?php echo $row['id']; ?> /></dt>
                            <?php
                            $i++;
                        }
                        ?>
                        <button type="submit" value="AddFriends">Accept Friends</button>
                        </form>
                        <?php
                        $requests = 1;
                    }

                    //outgoing requests
                    /*
                    $stmt = $pdo->prepare("SELECT f.friend_id, m.username, c.name as clan
                                           FROM friends as f
                                           JOIN members as m on m.id = f.friend_id
                                           JOIN clans as c on c.id = m.clan_id
                                           WHERE f.member_id = ? AND f.accepted = 0");
                    $stmt->execute(array($_SESSION['user_id']));
                    if ($stmt->rowcount() > 0) {
                        //pending outgoing requests
                        while ($row = $stmt->fetch()) {
                            ?>
                            <dt><a href="user.php?user=<?php echo $row['friend_id']; ?>"><?php echo $row['username']; ?></a></dt>
                            <dt><?php echo $row['clan']; ?></dt>
                            <?php
                        }
                        $requests = 1;
                    } */

                    //if no pending requests
                    if ($requests != 1) {
                        echo 'No pending friend requests';
                    }


                ?>

                <h3>Friends</h3>

                <?php

                $stmt = $pdo->prepare("SELECT f.friend, m.username, f.`timestamp`, f.accepted, c.name as clan
                                       FROM (
                                            SELECT member_id as friend, `timestamp`, accepted
                                            FROM friends
                                            WHERE friend_id = :user_id
                                            UNION ALL
                                            SELECT friend_id as friend, `timestamp`, accepted
                                            FROM friends
                                            WHERE member_id = :user_id
                                       ) as f
                                       JOIN members as m on m.id = f.friend
                                       JOIN clans as c on c.id = m.clan_id
                                       WHERE f.accepted = 1
                                       ORDER BY m.username");
                $stmt->execute(array(':user_id' => $_SESSION['user_id']));
                if($stmt->rowcount() > 0) {
                    while($row = $stmt->fetch()) {
                        ?>
                        <dt><a href="user.php?user=<?php echo $row['friend']; ?>"><?php echo $row['username']; ?></a></dt>
                        <dt><?php echo $row['clan']; ?></dt>
                        <?php $friend_start = date_create($row['timestamp']); ?>
                        <dt><?php echo $friend_start->format('F jS, Y'); ?></dt>
                        <?php
                    }
                } else {
                    echo 'No friends found.';
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