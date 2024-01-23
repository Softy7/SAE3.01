<?php
session_start();
require_once('../Model/AdminCapitain.php');
require_once('../Controller/launch.php');
require_once('../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

if ($user instanceof Administrator) {
$matchs = $user->getMatchs($bdd);
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
          ?><tr><th><?php echo "Parcours: ", $r[1]; if ($r[6] == 0) { echo " | Penalty";} else { echo " | Pari Max: ", $r[6];} ?></th><th>
        <?php
    if ($matchs == null) {
        ?>
        <t>Aucune rencontre n'est définie...</t>
        <?php
    } else {
        foreach($matchs as $match) {
            ?><form action="../Controller/AdminFunctions/getRun.php" method="post"><?php
            if ($match[8] == 1) {
                ?><th><?php echo $match[1], " | Contesté | ", $match[2]?>
                <input type="submit" name="_contest_<?php echo $match[0]?>"  value="+"></th><?php
            } else if ($match[6] == $r[0]) {
                if ($match[4] == 1) {
                        ?><table><tr><th><?php echo " Chôle: ",$match[1] ?></th> <th><?php echo " But " ?></th><th><?php echo "Déchôle : ", $match[2] ?></th> <th><?php echo "Pari: ", $match['3']?></th><th><?php echo " Coups déchôles: ", $match[11]?></th></tr></table><?php
                    } else if ($match[4] == 2) {
                        ?><table><tr><th><?php echo " Chôle: ",$match[1] ?></th> <th><?php echo " Défendu " ?></th><th><?php echo "Déchôle : ", $match[2] ?></th> <th><?php echo "Pari: ", $match['3']?></th><th><?php echo " Coups déchôles: ", $match[11]?></th></tr></table><?php
                    } else if ($match[6] != null && $match[9] != null && $match[10]!=null) {
                        ?><table><tr><th><?php echo $match[1] ?></th> <th><?php echo $match[9]?></th><th><?php echo $match[10] ?></th><th><?php echo $match[2] ?></th></table><?php
                    } else {
                        ?><table><tr><th><?php echo $match[1] ?></th> <th><?php echo $match[9]," En attente... ", $match[10] ?></th><th><?php echo $match[2] ?></th></table><?php
                    }
                }
            }
            } ?></form></th></tr><?php
    }

}
?></table>
<button onclick="window.location.href='../View/HomeTournaments/HomeTournaments.php';">Retour</button>
<?php
if ($run != null) {
    ?>
<?php
} else {
    header('location: ../Guest_home.html');
}