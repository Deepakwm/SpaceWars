<?php
include_once 'db_connect.php';
include_once 'psl-config.php';

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $friend_id = $value;
        $insert_stmt = $pdo->prepare("UPDATE friends
                                      SET accepted = 1
                                      WHERE id = ?");
        if (! $insert_stmt->execute(array($friend_id))) {
            header('Location: ../error.php?err=Friend add failure: INSERT');
        }
    }
    header('Location: ../friends.php');
}