<?php include_once 'header.php'; ?>
<?php if(isset($_GET['user'])) $user_id = $_GET['user'];
      else $user_id = ''; ?>
    <div class='container'>
        <?php if (login_check($pdo) == true) : ?>
                 <?php
                    $sql = 'SELECT username, forename, surname, gender, birthday, is_premium, `timestamp`
                        FROM members
                        WHERE id =' . $user_id;

                    if ($result = $pdo->query($sql)) {

                        /* fetch object array */
                        while ($row = $result->fetch()) {
                            $birthday = date_create($row['birthday']);
                            $age = $birthday->diff(new DateTime('now'))->y;
                            switch ($row['gender']) {
                                case 1:
                                    $gender = 'Male';
                                    break;
                                case 2:
                                    $gender = 'Female';
                                    break;
                                default:
                                    $gender = 'Unspecified';
                            }
                            switch ($row['is_premium']) {
                                case 1:
                                    $premium = 'Yes';
                                    break;
                                default:
                                    $premium = 'No';
                            }
                            $created = date_create($row['timestamp']);
                            ?>
                        <h3>User Profile (<?php echo $row['username']; ?>)</h3>
                        <dl class='dl-horizontal'>
                            <dt>First Name:</dt><dd><?php echo $row['forename']; ?></dd>
                            <dt>Last Name:</dt><dd><?php echo $row['surname']; ?></dd>
                            <dt>Gender:</dt><dd><?php echo $gender; ?></dd>
                            <dt>Birthday:</dt><dd><?php echo $birthday->format('F jS');; ?></dd>
                            <dt>Age:</dt><dd><?php echo $age; ?></dd>
                            <dt>Premium Member:</dt><dd><?php echo $premium; ?></dd>
                            <dt>Member Since:</dt><dd><?php echo $created->format('F jS, Y');; ?></dd>
                            <dt>Clan Information:</dt><dd><a href="clan.php?user=<?php echo $user_id; ?>">Clan Profile</a>
                        </dl>
                        <?php
                        }
                    }
                    else {
                        echo 'No user selected';
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