<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Protected Page</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <?php if (login_check($mysqli) == true) : ?>
            <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>! User <?php echo htmlentities($_SESSION['user_id']); ?>!</p>
            <p>
                <?php
                    $sql = 'SELECT forename, surname, gender, birthday FROM members WHERE id =' . $_SESSION['user_id'];

                    if ($result = $mysqli->query($sql)) {

                        /* fetch object array */
                        while ($row = $result->fetch_assoc()) {
                            $forename = $row['forename'];
                            $surname = $row['surname'];
                            $birthday = $row['birthday'];
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
                        }

                        /* free result set */
                        $result->close();
                    }

                ?>
                <div class='attribute'>First Name:</div><div class='value'><?php echo $forename; ?></div>
                <div class='attribute'>Last Name:</div><div class='value'><?php echo $surname; ?></div>
                <div class='attribute'>Gender:</div><div class='value'><?php echo $gender; ?></div>
                <div class='attribute'>Birthday:</div><div class='value'><?php echo $$date->format('Y-m-d'); ?></div>

            </p>
            <p>Return to <a href="login.php">login page</a></p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>