<?php

session_start();
require_once ('../../Model/AdminCapitain.php');
require_once ('../../Controller/launch.php');
require_once ('../../ConnexionDataBase.php');

$bdd = __init__();

$user = launch();

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, '_id_name_')!==false) {
            $runname = str_replace('_id_name_', '', $key);
            $matchs = $user->getMatchInRun($bdd, $runname);
            $teams = $user->getTeamsNotInRun($bdd, $runname);
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Cholage Club Quaroule.fr</title>
                <link href="viewMatch.css" rel="stylesheet">
            </head>
            <body>
            <h1>Créer un Match</h1>
            <table>
            <?php

        }
    }
} else {
    header("location: ../../View/Guest_Home.html");
}