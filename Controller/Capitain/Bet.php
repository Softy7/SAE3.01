<?php
session_start();
require_once("../launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd = __init__();
$user = launch();

$idMatch=$_POST[0];

$requete=$bdd->prepare("Select attack,defend WHERE idmatch=:idmatch");
$requete->bindParam(':idmatch',$idMatch);
$requete->execute();
$req=$requete->fetchAll();

if ($req[1]!=$user->getTeam()) {
    $equipe1 = $req[0];
    $equipe2 = req[1];
}
else{
    $equipe1 =req[1] ;
    $equipe2 =$req[0] ;
}

if (!empty($_POST["pari"])){
    $requete1=$bdd->prepare("INSERT INTO bet VALUES(:cap,:idmatch,:pari)");
    $requete1->bindParam(':cap',$user->username);
    $requete1->bindParam(':idmatch',$idMatch);
    $requete1->bindParam(':pari',$_POST['pari']);
    $requete1->execute();
    if (requete[2]==null){
        $requete2=$bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2 AND betteamkept=:bet");
        $requete2->bindParam(":equipe1", $equipe1);
        $requete2->bindParam(":equipe2", $equipe2);
        $requete2->bindParam(":bet", $_POST['pari']);
        $requete2->execute();
    }
    elseif ($requete[2]>$_POST['pari']){
        $requete3=$bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2 AND betteamkept=:bet");
        $requete3->bindParam(":equipe1", $equipe1);
        $requete3->bindParam(":equipe2", $equipe2);
        $requete3->bindParam(":bet", $_POST['pari']);
        $requete3->execute();
    }
}
