<?php
require_once('../../ConnexionDataBase.php');
require_once('../launch.php');
require_once ('../../Model/AdminCapitain.php');

session_start();
$bdd = __init__();
$user = launch();

if (isset($_POST['generate'])) {
    $user->createMatchs($bdd);
    sleep(1);
    header('location: ../../View/AdminViews/TournamentView.php');
}

if (isset($_POST['destroy'])) {
    $user->destroyTournament($bdd);
    sleep(1);
    header('location: ../../View/AdminViews/TournamentView.php');
}

?>
