<?php
session_start();

require_once("../launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd = __init__();
$user = launch();
$team=$user->getTeam();

$requete=$bdd->prepare("SELECT * FROM Match WHERE (contestation IS null) AND (attack=:equipeCap OR defend=:teamCap) ORDER BY(idmatch)");
$requete->bindParam(':equipeCap',$team);
$requete->bindParam(':teamCap',$team);
$requete->execute();
$req=$requete->fetchAll();
$idMatch=$req[0][0];

echo $idMatch;

if (isset($_POST["nbdechole"])) {
    $requete1 = $bdd->prepare("Update Match SET score=:score, goal=:win WHERE idmatch=:idMatch");
    $requete1->bindParam(':score', $_POST["nbdechole"]);
    if (isset($_POST["win"])){
        $won=1;
        $requete1->bindParam(':win', $won);
    }else{

        $lost=2;
        $requete1->bindParam(':win', $lost);
    }
    echo 'won : ';
    echo $won;
    echo ' ';

    echo 'score : ';
    echo $_POST["nbdechole"];
    echo ' ';

    echo 'idMatch : ';
    echo $idMatch;
    echo ' ';
    $requete1->bindParam(':idMatch', $idMatch);
    echo ' MARCHE TA MERE';

    $requete1->execute();
    echo 'fini';
    header('location: ../../View/HomeTournaments/HomeTournaments.php');
}
else{
    foreach ($_POST as $key => $value) {
        if (!strpos($key, 'contestation')) {
            echo 'enculer';
            $contestation = true;
            $requete2 = $bdd->prepare("Update Match SET contestation=:contestation WHERE idmatch=:idMatch");
            $requete2->bindParam(':contestation', $contestation);
            $requete2->bindParam(':idMatch', $idMatch);
            $requete2->execute();
            header('location: ../../View/HomeTournaments/HomeTournaments.php');

        } elseif (!strpos($key, 'confirmer')) {
            echo 'fils de pute';
            $contestation = false;
            $requete3 = $bdd->prepare("Update Match SET contestation=:contestation WHERE idmatch=:idMatch");
            $requete3->bindParam(':contestation', $contestation);
            $requete3->bindParam(':idMatch', $idMatch);
            $requete3->execute();
            header('location: ../../View/HomeTournaments/HomeTournaments.php');

        }
    }
}





?>