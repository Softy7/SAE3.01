<?php
session_start();

require_once("../launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd = __init__();
$user = launch();
$nextMatch = $user->getMatchNotPlayed($bdd);

if (!isset($_POST['confirm'])&&(($nextMatch[0][11]==1)||($nextMatch[0][4]>2))) {
    $user->contest($nextMatch[0][0]);
    if ($nextMatch[0][7] == 1) {
        $user->enterScorePenal($bdd, $nextMatch[0][9], $nextMatch[0][10], $nextMatch[0][0]);
    } else {
        $user->enterScore($bdd, $nextMatch[0][11], $nextMatch[0][4]-2, $nextMatch[0][0]);
    }
}

if (isset($_POST['confirm'])) {
    if ($nextMatch[0][7] != 1) {
        $user->enterScore($bdd, $nextMatch[0][11], $nextMatch[0][4] - 2, $nextMatch[0][0]);
    } else {
        $user->enterScorePenal($bdd, $_POST['attack'], $_POST['defend'], $nextMatch[0][0]);
    }
}

if (isset($_POST['attack'])&&isset($_POST['defend'])&&$nextMatch[0][7]==1) {
    $user->enterScorePenal($bdd, $_POST['attack'], $_POST['defend'], $nextMatch[0][0], 1);
}
if (isset($_POST['dock'])&&$nextMatch[0][7]!=1) {
    $user->enterScore($bdd, $_POST['score'], 3, $nextMatch[0][0]);
} else if ((!isset($_POST['dock']))&&$nextMatch[0][4]!=null) {
    $user->enterScore($bdd, $_POST['score'], 4, $nextMatch[0][0]);
}



?>