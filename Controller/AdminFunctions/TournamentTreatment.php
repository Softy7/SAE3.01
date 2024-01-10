<?php
require_once('../../ConnexionDataBase.php');
session_start();
$bdd = __init__();

function organiserTournoi($joueurs, $rondes) {
    $nombreJoueurs = count($joueurs);
    $milieu = $nombreJoueurs / 2;
    $matchs = [];
    foreach ($rondes as $ronde) {
        $appariements = [];
        for ($i = 0; $i < $milieu; $i++) {
            $joueur1 = $joueurs[$i];
            $joueur2 = $joueurs[$nombreJoueurs - 1 - $i];
            $appariements[] = array($joueur1, $joueur2);
        }$matchs[$ronde] = $appariements;
        $joueurTemp = $joueurs[1];
        for ($i = 1; $i < $nombreJoueurs - 1; $i++) {
            $joueurs[$i] = $joueurs[$i + 1];
        }$joueurs[$nombreJoueurs - 1] = $joueurTemp;}
    return $matchs;
}

function supprimerTableMatch($bdd){
    $requete = $bdd->prepare("DELETE FROM match");
    $requete->execute();
}

function remplirTableMatch($tournoi,$bdd)
{
    foreach ($tournoi as $parcours => $rencontres) {
        foreach ($rencontres as $rencontre) {

            $request = $bdd->prepare("SELECT idrun FROM run WHERE title = :title");
            $request->bindParam(':title', $parcours);
            $request->execute();
            $res = $request->fetch();
            $request = $bdd->prepare("INSERT INTO match VALUES (DEFAULT,:attack,:defend,0,0,0,:idrun,true,true,0,0,0)");
            $request->bindParam(':attack', $rencontre[0]);
            $request->bindParam(':defend',$rencontre[1]);
            $request->bindParam(':idrun', $res['idrun']);
            $request->execute();
        }
    }
}
?>
