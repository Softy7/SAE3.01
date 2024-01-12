<?php
require_once ('../launch.php');
require_once ('../../ConnexionDataBase.php');
require_once ('../../Model/AdminCapitain.php');
session_start();

$user = launch();
$db = __init__();

if (isset($_POST['__Send__'])) {
    $match = $_SESSION['OneMatch'][0];
    $db = __init__();
    $user = launch();
    if (isset($_POST['Goal'])&&$_POST['Turn']<=$match[3]) {
        $user->setContest($db, $match[0], 1, $_POST['Turn']);
    } else {
        $user->setContest($db, $match[0], 2, $_POST['Turn']);
    }
    header('location: ../../View/AdminViews/MatchChanged.php');
} else {
    header('location: ../../View/AdminViews/MatchUnchanged.php');
}
