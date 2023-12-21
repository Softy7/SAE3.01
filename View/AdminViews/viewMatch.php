<?php
session_start();
require_once ('../../Model/AdminCapitain.php');
require_once ('../../Controller/launch.php');
require_once ('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

if ($user instanceof Administrator) {
$matchs = $user->getMatch($bdd, null);
$run = $user->getRun($bdd);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewMatch.css" rel="stylesheet">
    </head>
<body>
<h1>Gestion Matchs</h1>
<table><?php
    if ($run == null) {
        ?><t>Aucun parcours n'existe... Veuillez créer un parcours afin de créer une rencontre.</t><?php
    }
foreach ($run as $r) {
          ?><tr><th><?php echo "Parcours: ", $r[1]; if ($r[6] == 0) { echo " | Penalty";} else {echo " | Pari Max: ", $r[6];} ?></th>
        <?php
    if ($matchs == null) {
        ?>
        <t>Aucune rencontre n'est définie...</t>
        <?php
    } foreach($matchs as $match) {
        ?><form action="../../Controller/AdminFunctions/getMatch.php" method="post"><?php
        if ($match[8] == 1) {
            ?><th><?php echo " Chôle: ",$match[1], " | Contesté | Déchôle : ", $match[2], " "?>
            <input type="submit" name="_contest_<?php echo $match[0]?>"  value="+"></th><?php
        } else if ($match[6] == $r[0]) {
            if ($match[4] == 1) {
                ?><th><?php echo " Chôle: ",$match[1], " | G : P | Déchôle : ", $match[2], " | Pari: ", $match['3'], " | Coups déchôles: ", $match[11]?></th><?php
            } else if ($match[4] == 2) {
                ?><th><?php echo " Chôle: ",$match[1], " | P : G | Déchôle : ", $match[2], " | Pari: ", $match['3'], " | Coups déchôles: ", $match[11]?><?php
            } else if ($match[6] != null && $match[9] != null && $match[10]!=null) {
                ?><th><?php echo " Chôle: ",$match[1], " | ", $match[9]," : ",$match[10], " | Déchôle : ", $match[2]?></th><?php
            } else {
                ?><th><?php echo " Chôle: ",$match[1], " |  :  | Déchôle : ", $match[2]?></th><?php
            }
        }
    }
        ?></form></tr>

    <?php
}
?></table>
<button onclick="window.location.href='../HomeTournaments/HomeTournaments.php';">Retour</button>
<?php
if ($run != null) {
    ?>
<?php
}
} else {
    header('location: ../Guest_home.html');
}