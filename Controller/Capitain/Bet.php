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

if ($req[0][2] != $user->getTeam()) {
    $equipe1 = $req[0][1];
    $equipe2 = $req[0][2];
} else {
    $equipe1 = $req[0][2];
    $equipe2 = $req[0][1];
}

if (isset($_POST["pari"])) {
    $user->insertIntoBet($bdd,$idMatch,$_POST["pari"]);
    if ($req[2]==null){
        $user->bet($bdd,$idMatch,$_POST["pari"],$equipe2);
        header('location: ../../View/HomeTournaments/HomeTournaments.php');
    } elseif ($req[0][3] > $_POST['pari']) {
        $user->bet($bdd,$idMatch,$_POST["pari"],$equipe2);
        header('location: ../../View/HomeTournaments/HomeTournaments.php');
    } elseif ($req[0][3] == $_POST['pari']) {
        $user->betIfEquals();
            header('location: ../../View/HomeTournaments/HomeTournaments.php');
    }


    else {
        header('location: ../../View/HomeTournaments/HomeTournaments.php');
    }
}
