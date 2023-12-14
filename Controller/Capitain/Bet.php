<?php
session_start();
require_once("../launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd = __init__();
$user = launch();

$team=$user->getTeam();

$requete=$bdd->prepare("SELECT * FROM Match WHERE (score = 0) AND (attack=:equipeCap OR defend=:teamCap) ORDER BY(idmatch)");
$requete->bindParam(':equipeCap',$team);
$requete->bindParam(':teamCap',$team);
$requete->execute();
$req=$requete->fetchAll();

$idMatch=$req[0][0];

if ($req[0][2] != $user->getTeam()) {
    $equipe1 = $req[0][1];
    $equipe2 = $req[0][2];
} else {
    $equipe1 = $req[0][2];
    $equipe2 = $req[0][1];
}

if (isset($_POST["pari"])) {
    $requete1 = $bdd->prepare("INSERT INTO bet VALUES(:cap,:idmatch,:pari)");
    $requete1->bindParam(':cap', $user->username);
    $requete1->bindParam(':idmatch', $idMatch);
    $requete1->bindParam(':pari', $_POST['pari']);
    $requete1->execute();
    if ($req[0][3] == null) {
        $requete2 = $bdd->prepare("UPDATE Match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
        $requete2->bindParam(":equipe1", $equipe1);
        $requete2->bindParam(":equipe2", $equipe2);
        $requete2->bindParam(":bet", $_POST['pari']);
        $requete2->bindParam(':idMatch',$idMatch);
        $requete2->execute();
        header('location: ../../View/HomeTournaments/HomeTournaments.php');
    } elseif ($req[0][3] > $_POST['pari']) {
        $requete3 = $bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
        $requete3->bindParam(":equipe1", $equipe1);
        $requete3->bindParam(":equipe2", $equipe2);
        $requete3->bindParam(":bet", $_POST['pari']);
        $requete3->bindParam(':idMatch',$idMatch);
        $requete3->execute();
        header('location: ../../View/HomeTournaments/HomeTournaments.php');
    } elseif ($req[0][3] == $_POST['pari']) {
        $random=$user->betIfEquals();
        echo $random;
        if ($random==1){
            $requete4 = $bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
            $requete4->bindParam(":equipe1", $equipe1);
            $requete4->bindParam(":equipe2", $equipe2);
            $requete4->bindParam(":bet", $_POST['pari']);
            $requete4->bindParam(':idMatch',$idMatch);
            echo 2;
            $requete4->execute();
            echo 3;
            header('location: ../../View/HomeTournaments/HomeTournaments.php');
        }

        elseif ($random==2){
            echo 4;
            $requete5 = $bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
            $requete5->bindParam(":equipe1", $equipe2);
            $requete5->bindParam(":equipe2", $equipe1);
            $requete5->bindParam(":bet", $_POST['pari']);
            $requete5->bindParam(':idMatch',$idMatch);
            $requete5->execute();
            header('location: ../../View/HomeTournaments/HomeTournaments.php');
        }


    } else {
        header('location: ../../View/HomeTournaments/HomeTournaments.php');
    }
}
?>

