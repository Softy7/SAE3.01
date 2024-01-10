<?php
require_once ('../launch.php');
require_once ('../../ConnexionDataBase.php');
require_once ('../../Model/AdminCapitain.php');
session_start();

if (isset($_POST['T1'])&&isset($_POST['T2'])&&$_POST['T1']>=0&&$_POST['T2']>=0) {
    $match = $_SESSION['OneMatch'][0];
    $db = __init__();
    $user = launch();
    $user->setScoreContest($db, $match[0], $_POST['T1'], $_POST['T2']);
    header('location: ../../View/AdminViews/MatchChanged.php');
} else {
    header('location: ../../View/AdminViews/MatchUnchanged.php');
}