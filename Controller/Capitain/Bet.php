<?php
session_start();
require_once("../launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd = __init__();
$user = launch();

$team=$user->getTeam();

$req=$user->getMatchNotPlayed($bdd);

$idMatch=$req[0][0];
$max = $user->nextMatchBet($req[0][6]);
$bets = $user->getBet($bdd, $req[0][0]);

if ($req[0][2] != $user->getTeam()) {
    $equipe1 = $req[0][1];
    $equipe2 = $req[0][2];
} else {
    $equipe1 = $req[0][2];
    $equipe2 = $req[0][1];
}

if (isset($_POST["bet"])) {
    $user->insertIntoBet($bdd, $idMatch, $_POST["bet"]);
    $bets = $user->getBet($bdd, $req[0][0]);
    if (count($bets)==2) {
        if ($bets[0][2] == $bets[1][2]) {
            $user->betIfEquals($bdd, $idMatch, $_POST['bet'], $equipe2);
        } else if ($bets[0][2] > $bets[1][2]) {
            $user->bet($bdd, $idMatch, $_POST["bet"], $equipe2);
        } else {
            $user->bet($bdd, $idMatch, $_POST["bet"], $equipe1);
        }
    }
    header('location: ../../View/HomeTournaments/HomeTournaments.php');
} else {
    header('location: ../../View/HomeTournaments/HomeTournaments.php');
}