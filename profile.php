<?php include_once 'header.php'; ?>
    <div class='container'>
        <?php if (login_check($pdo) == true) : ?>
            <h1>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h1>
                <?php
                    $stmt = $pdo->prepare("SELECT forename, surname, gender, birthday, is_premium, `timestamp`
                                           FROM members
                                           WHERE id = ?");
                    $stmt->execute(array($_SESSION['user_id']));
                    $row = $stmt->fetch();
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
                <h3>Personal Information <small><a href='#'>edit</a></small></h3>
                <dl class='dl-horizontal'>
                    <dt>First Name:</dt><dd><?php echo $row['forename']; ?> </dd>
                    <dt>Last Name:</dt><dd><?php echo $row['surname']; ?></dd>
                    <dt>Gender:</dt><dd><?php echo $gender; ?></dd>
                    <dt>Birthday:</dt><dd><?php echo $birthday->format('F jS'); ?></dd>
                    <dt>Age:</dt><dd><?php echo $age; ?></dd>
                    <dt>Premium Member:</dt><dd><?php echo $premium; ?></dd>
                    <dt>Member Since:</dt><dd><?php echo $created->format('F jS, Y'); ?></dd>
                </dl>

            <p>Return to <a href="login.php">login page</a></p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.
            </p>
        <?php endif; ?>
    </div>
    </body>
</html>