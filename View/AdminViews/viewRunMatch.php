<?php
session_start();
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Controller/launch.php');
require_once('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

if ($user instanceof Administrator) {
$run = $user->getRun($bdd);
$teams = $user->getTeams($bdd);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewRunMatch.css" rel="stylesheet">
</head>
<body>
<header>
<center><h1>Liste Parcours:</h1></center>
</header>
<main>
<table><?php
    if ($run == null) {
        ?><tr><th>Aucun parcours n'existe... Veuillez créer un parcours afin de créer une rencontre.</th></tr><?php
    } else {
        ?><form action="../../Controller/AdminFunctions/getRun.php" method="post">
        <tr><th>Sélectionnez un parcours:</th></tr><?php

        foreach ($run as $r) {
            ?><tr><th><input type="submit" name="_idRun_<?php echo $r[0]?>" value="<?php echo "Parcours: ", $r[1]; if ($r[5] == 0) { echo " Penalty";} else { echo " Pari Max: ", $r[5];} ?>"></th></tr><?php
        }
        ?><?php
    }
    ?></form></table>


    <table><?php
    if ($teams == null) {
        ?><tr><th>Aucune équipe n'est présente. Pas de match possible.</th></tr><?php
    } else {
    ?><form action="../../Controller/AdminFunctions/getTeamMatch.php" method="post">
        <tr><th>Sélectionnez une équipe:</th></tr><?php

        foreach ($teams as $t) {
            ?><tr><th><input type="submit" id="_teamName_" name="_teamName_<?php echo $t[0]?>" value="<?php echo $t[0]?>"></th></tr><?php
        }
        ?><?php
    }
            ?></form><tr><th><button onclick="window.location.href='../HomeTournaments/HomeTournaments.php';">Retour</button></th></tr></table>
</main>

    <?php
} else {
    header('location: ../MemberViewMatch/viewRunMatch.php');
}