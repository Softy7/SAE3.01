<?php
session_start();

require_once("../launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd = __init__();
$user = launch();


$req=$user->getMatchNotValidated($bdd);
$idMatch=$req[0][0];


if (isset($_POST["nbdechole"])) {


    if (isset($_POST["win"])){
        $won=1;
        $user->enterScore($bdd,$_POST["nbdechole"],$won,$idMatch);

    }else{

        $lost=2;
        $user->enterScore($bdd,$_POST["nbdechole"],$lost,$idMatch);
    }


    header('location: ../../View/HomeTournaments/HomeTournaments.php');
}
else{
    foreach ($_POST as $key => $value) {
        if (!strpos($key, 'contestation')) {
            $contestation = true;
            $user->confirmation($bdd,$contestation,$idMatch);
            header('location: ../../View/HomeTournaments/HomeTournaments.php');

        } elseif (!strpos($key, 'confirmer')) {
            $confirmation = false;
            $user->confirmation($bdd,$confirmation,$idMatch);
            header('location: ../../View/HomeTournaments/HomeTournaments.php');

        }
    }
}





?>