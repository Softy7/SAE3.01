<?php
session_start();
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../Controller/launch.php');
require_once('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();
$init = new Administrator("", "", "", "", "", "");

if ($user instanceof Member) {
$run = $init->getRun($bdd);

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
        ?><tr><th>Aucun parcours n'existe... </th></tr><?php
    } else {
        ?><form action="viewMatch.php" method="post">
        <tr><th>Sélectionnez un parcours:</th></tr><?php

        foreach ($run as $r) {
            ?><tr><th><input type="submit" name="_idRun_<?php echo $r[0]?>" value="<?php echo "Parcours: ", $r[1]; if ($r[6] == 0) { echo " Penalty";} else { echo " Pari Max: ", $r[6];} ?>"></th></tr><?php
        }
        ?><?php
    }
    ?></form></table>
    <table><tr><th><button onclick="window.location.href='../HomeTournaments/HomeTournaments.php';">Retour</button></th></tr></table>
    </main><?php
} else {
    header('location: ../Guest_home.html');
}