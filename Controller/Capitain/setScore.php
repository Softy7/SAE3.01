<?php
session_start();

require_once("../launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd = __init__();
$user = launch();
$nextMatch = $user->getMatchNotPlayed($bdd);

    
if(isset($_POST['enter'])) {
    if (isset($_POST['attack'])&&isset($_POST['defend'])&&$nextMatch[0][7]==1) {
        $user->enterScorePenal($bdd, $_POST['attack'], $_POST['defend'], $nextMatch[0][0], 1);
    } else if (isset($_POST['dock'])) {
        $user->enterScore($bdd, $_POST['score'], 3, $nextMatch[0][0]);
    } else {
        $user->enterScore($bdd, $_POST['score'], 4, $nextMatch[0][0]);
    }
}

header('location: ../../View/HomeTournaments/HomeTournaments.php');

?>