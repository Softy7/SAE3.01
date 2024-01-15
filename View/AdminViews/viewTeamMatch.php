<?php
session_start();
require_once('../../Model/AdminCapitain.php');
require_once('../../Controller/launch.php');
require_once('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

if ($user instanceof Administrator) {
    $teamName = $_SESSION['tname'];
    $matchs = $_SESSION['match'];
    $contests = array();

    ?><!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset=UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewMatch.css" rel="stylesheet">
</head>
<body>
<header>
    <center><h1>Gestion Matchs: <?php echo $teamName?></h1></center>
</header>
<main>
    <?php
    if ($matchs == null) {
        ?>
        <t>Aucune rencontre définie pour l'équipe sélectionnée...</t>
        <?php
    } else {
        foreach($matchs as $match) {
            if ($match[8] != 1) {
                if ($match[4] == 1) {
                    ?><table><tr><th><input type="submit" id="correct" value="<?php echo $match[1], " 1 - 0 ", $match[2], ' Pari:',$match[3], ' Coups:', $match[11]?>"></th></tr></table><?php
                } else if ($match[4] == 2) {
                    ?><table><tr><th><input type="submit" id="correct" value="<?php echo $match[1], " 0 - 1 ", $match[2], ' Pari:',$match[3], ' Coups:',$match[11]?>"</th></tr></table><?php
                } else if ($match[6] != null && $match[9] != null && $match[10]!=null) {
                    ?><table><tr><th><input type="submit" id="correct" value="<?php echo $match[1], ' ', $match[9]," - ", $match[10], ' ', $match[2], " (Penalty)"?>"</th></tr></table><?php
                } else {
                    ?><table><tr><th><input type="submit" id="correct" value="<?php echo $match[1], " - ", $match[2]?>"</th></tr></table><?php
                }
            } else {
                $contests[-1] = $match;
            }
        }
        ?><form action="Winner.php" method="post"><?php
        foreach($contests as $match) {
            if ($match[6] != null) {
                $str = " $match[9] - $match[10] ";
            } else {
                $bet = "Pari: $match[3], Coups: $match[11]";
                if ($match[4] == 1) {
                    $str = " 1 - 0 ";
                } else if ($match[4] == 2) {
                    $str = " 0 - 1 ";
                } else {
                    $str = " Erreur ";
                }
            }
            ?><table><tr><th><input type="submit" name="_contest_<?php echo $match[0]?>" value="<?php echo $match[1], $str, $match[2]?>"</th></tr></table><?php
        } ?></form><?php
    } ?>
    <table><tr><th><button onclick="window.location.href='viewRunMatch.php';">Retour</button></th></tr></table></main>
<?php
} else {
    header('location: ../Guest_home.html');
}