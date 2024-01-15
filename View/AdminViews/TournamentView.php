<?php

require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

session_start();

$user = launch();
if ($_SESSION['isAdmin'] == 1) {

    $bdd = __init__();
    $run = $user->getRun($bdd);
    $match = $user->getMatch($bdd);

    ?><!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset=UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewMatch.css" rel="stylesheet">
</head>
<body>
<header>
    <center><h1>Génération Tournoi</h1></center>
</header>
<main>
    <?php

    if ($match == null) {
        $teams = count($user->getTeams($bdd));
        $cruns = count($user->getRun($bdd));

        if (($teams%2 == 0)&&($cruns>0)) {?>
            <table><tr><th><form action="../../Controller/AdminFunctions/TournamentTreatment.php" method="post">
                <input type="submit" name="generate" value="Générer Tournoi">
            </form></th></tr></table>
            <?php
        } else {
            ?>
            <table><tr><th>Génération Impossible. <?php echo $teams, " Equipes et ", $cruns, " Parcours présents."?></th></tr></table>
            <?php
        }
    } else {

        ?>
        <table><tr><th><form action="../../Controller/AdminFunctions/TournamentTreatment.php" method="post">
            <input type="submit" name="destroy" value="Détruire Tournoi">
            </form></th></tr></table>
        <?php
        foreach ($run as $r) {
            ?>
            <table><tr><th>Parcours: <?php echo $r[1]?></th></tr></table>
            <?php
            foreach ($match as $m) {
                if ($m[6] == $r[0]) {
                    if ($m[4] == 1) {
                        ?><table><tr><th><input type="submit" id="correct" value="<?php echo $m[1], " 1 - 0 ", $m[2], ' Pari:',$m[3], ' Coups:', $m[11]?>"></th></tr></table><?php
                    } else if ($m[4] == 2) {
                        ?><table><tr><th><input type="submit" id="correct" value="<?php echo $m[1], " 0 - 1 ", $m[2], ' Pari:',$m[3], ' Coups:',$m[11]?>"</th></tr></table><?php
                    } else if ($m[7] != null && $m[9] != null && $m[10]!=null) {
                        ?><table><tr><th><input type="submit" id="correct" value="<?php echo $m[1], ' ', $m[9]," - ", $m[10], ' ', $m[2]?>"</th></tr></table><?php
                    } else {
                        ?><table><tr><th><input type="submit" id="correct" value="<?php echo $m[1], " - ", $m[2]?>"</th></tr></table><?php
                    }
                }
            }
        }
        } ?>
    <table><tr><th><button onclick="window.location.href='../../Controller/Connect/CheckConnect.php';">Retour</button></th></tr></table></main>
<?php
} else {
    header('location: ../Guest_Home.html');
}
