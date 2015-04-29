<?php
include_once $env.'/psl-config.php';

function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"],
        $cookieParams["domain"],
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session
    session_regenerate_id();    // regenerated the session, delete the old one.
}

function login($email, $password, $pdo) {
    if ($stmt = $pdo->prepare("SELECT id, username, password, salt
                                FROM members
                                WHERE email = ?
                                LIMIT 1")) {
        $stmt->execute(array($email));
        $row = $stmt->fetch();

        $password = hash('sha512', $password . $row['salt']);
        if ($stmt->rowcount() == 1) {
            if (checkbrute($row['id'], $pdo) == true) {
                // add functionality to send email to user saying account is locked
                return false;
            } else {
                if ($row['password'] == $password) {
                    //correct password entered
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $user_id = preg_replace("/[^0-9]+/", "", $row['id']);
                    $_SESSION['user_id'] = $user_id;
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $row['username']);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    //invalid login attempt
                    $user_id = $row['id'];
                    $stmt = $pdo->prepare("INSERT INTO login_attempts(user_id, time)
                                           VALUES ('$user_id', now())");
                    $stmt->execute();
                    return false;
                }
            }
        } else {
            // no user exists
            return false;
        }

    }
}

function checkbrute($user_id, $pdo) {
    if($stmt = $pdo->prepare("SELECT time
                              FROM login_attempts
                              WHERE user_id = ?
                              AND time BETWEEN DATE(adddate(now(),interval -2 HOUR)) AND NOW()")) {
        $stmt->execute(array($user_id));
        if ($stmt->rowcount() > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($pdo) {
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if($stmt = $pdo->prepare("SELECT password
                                  FROM members
                                  WHERE id = ?
                                  LIMIT 1")) {
            $stmt->execute(array($user_id));
            if($stmt->rowcount() == 1) {
                $row = $stmt->fetch();
                $login_check = hash('sha512', $row['password'] . $user_browser);

                if ($login_check == $login_string) {
                    // logged in
                    return true;
                } else {
                    // not logged in
                    return false;
                }
            } else {
                // not logged in
                return false;
            }
        } else {
            // not logged in
            return false;
        }
    } else {
        // not logged in
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function get_new_mail($user_id, $pdo) {

    $stmt = $pdo->prepare("SELECT *
                           FROM messages
                           WHERE to_user = ? AND is_read <> 1 AND deleted <> 1");
    $stmt->execute(array($user_id));
    return $stmt->rowcount();
}