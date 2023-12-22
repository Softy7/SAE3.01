<?php
require_once('../ConnexionDataBaseNR.php');
session_start();
$bdd = __init__();


function organiserTournoi($joueurs, $rondes) {
    $nombreJoueurs = count($joueurs);
    $milieu = $nombreJoueurs / 2;

    $matchs = [];

    foreach ($rondes as $ronde) {
        $appariements = [];

        // Boucle pour créer les appariements à partir de la rotation des joueurs
        for ($i = 0; $i < $milieu; $i++) {
            $joueur1 = $joueurs[$i];
            $joueur2 = $joueurs[$nombreJoueurs - 1 - $i];
            $appariements[] = array($joueur1, $joueur2);
        }

        $matchs[$ronde] = $appariements;

        // Rotation des joueurs pour la prochaine ronde
        $joueurTemp = $joueurs[1];
        for ($i = 1; $i < $nombreJoueurs - 1; $i++) {
            $joueurs[$i] = $joueurs[$i + 1];
        }
        $joueurs[$nombreJoueurs - 1] = $joueurTemp;
    }

    return $matchs;
}

$request = $bdd->prepare("SELECT teamname FROM team");
$request->execute();
$equipes_fetch = $request->fetchAll(PDO::FETCH_ASSOC);

$request = $bdd->prepare("SELECT title FROM run");
$request->execute();
$parcours_fetch = $request->fetchAll(PDO::FETCH_ASSOC);

$parcours = array();
foreach ($parcours_fetch as $element) {
    $parcours[] = $element['title'];
}

$equipes = array();
foreach ($equipes_fetch as $element) {
    $equipes[] = $element['teamname'];
}

$tournoi = organiserTournoi($equipes, $parcours);

function printTournoi($tournoi) {


    foreach ($tournoi as $parcours => $rencontres) {
        echo "<table border='1'>";
        echo "<tr><th colspan='2'>$parcours</th></tr>";

        foreach ($rencontres as $rencontre) {
            echo "<tr><td>{$rencontre[0]}</td><td>{$rencontre[1]}</td></tr>";
        }

        echo "</table><br>";

    }
}
function rentrerTournoi($tournoi,$bdd)
{
    foreach ($tournoi as $parcours => $rencontres) {
        foreach ($rencontres as $rencontre) {
            $query = $bdd->prepare("INSERT INTO match (attack,defense,parcours) VALUES (:attack,:defense,:parcours)");

            $query->bindParam(':attack', $rencontre[0]);
            $query->bindParam(':defense', $rencontre[1]);
            $query->bindParam(':parcours', $parcours);
            $query->execute();
        }
    }
}

printTournoi($tournoi);
rentrerTournoi($tournoi,$bdd);

