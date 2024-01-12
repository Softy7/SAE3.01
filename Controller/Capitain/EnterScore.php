<?php
session_start();
require_once("../launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd = __init__();
$user = launch();

$team=$user->getTeam();

$requete=$bdd->prepare("SELECT * FROM Match WHERE (contestation = null) AND (attack=:equipeCap OR defend=:teamCap) ORDER BY(idmatch)");
$requete->bindParam(':equipeCap',$team);
$requete->bindParam(':teamCap',$team);
$requete->execute();
$req=$requete->fetchAll();

$idMatch=$req[0][0];



if (isset($_POST["score"])) {
    $requete1 = $bdd->prepare("Update Match SET score=:score, goal=:win WHERE idmatch=:idMatch");
    $requete1->bindParam(':score', $_POST["score"]);
    if (isset($_POST["win"])){
        $won=true;
        $requete1->bindParam(':goal', $won);
    }else{
        $lose=false;
        $requete1->bindParam(':goal', $lose);
    }
    $requete1->bindParam(':idMatch', $idMatch);
    $requete1->execute();

    header('location: ../../View/HomeTournaments/HomeTournaments.php');
}
elseif (isset($_POST["valider"])) {
    $contestation = false;
    $requete2 = $bdd->prepare("Update Match SET contestation=:contestation WHERE idmatch=:idMatch");
    $requete2->bindParam(':contestation',$contestation);
    $requete2->execute();
}
else {
    header('location: ../../View/HomeTournaments/HomeTournaments.php');
}

?>