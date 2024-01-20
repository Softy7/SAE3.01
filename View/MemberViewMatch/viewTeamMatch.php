<?php
session_start();
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../Controller/launch.php');
require_once('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

if ($user instanceof Member) {
$init = new Administrator("", "", "", "", "", "");

$team = 0;
$matchs = 0;
$contests = array();

foreach ($_POST as $key => $value) {
    if (!strpos($key, '_teamName_')) {
        $tn = str_replace('_teamName_', '', $key);
        if(!strpos($key, '_')) {
            $tn = str_replace('_', ' ', $tn);
            $matchs = $init->getMatch($bdd, $tn);
        }
        $team = $tn;
    }
}

if ($team == 0) {
    header('location: viewRunMatch.php');
}

?><!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset=UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewMatch.css" rel="stylesheet">
</head>
<body>
<header>
    <center><h1>Vue Matchs Equipe: <?php echo $team?></h1></center>
</header>
<main>
    <table><?php
        if ($matchs == null) {
            ?>
            <t>Aucune rencontre n'est définie...</t>
            <?php
        } else {
            foreach($matchs as $match) {
                if ($match[8] != 1) {
                    if ($match[4] == 1) {
                        ?><table><tr><th><input type="submit" id="correct" value="Chole <?php echo $match[1], " 1 - 0 ", $match[2], ' Paris: ', $match[3], ' Coups: ', $match[11]?>"></th></tr></table><?php
                    } else if ($match[4] == 2) {
                        ?><table><tr><th><input type="submit" id="correct" value="Déchole <?php echo $match[1], " 0 - 1 ", $match[2], ' Paris: ', $match[3], ' Coups: ', $match[11]?>"</th></tr></table><?php
                    } else if ($match[7] != null && $match[9] != null && $match[10]!=null) {
                        ?><table><tr><th><input type="submit" id="correct" value="<?php echo $match[1], ' ', $match[9]," - ", $match[10], ' ', $match[2], '(Penalty)'?>"</th></tr></table><?php
                    } else {
                        ?><table><tr><th><input type="submit" id="correct" value="<?php echo $match[1], " - ", $match[2]?>"</th></tr></table><?php
                    }
                } else {
                    $contests[] = $match;
                }
            }
            foreach($contests as $match) {
                if ($match[7] != null) {
                    $str = " $match[9] - $match[10] ";
                    $bet = " (Penalty)";
                } else {
                    $bet = " Pari: $match[3], Coups: $match[11]";
                    if ($match[4] == 1) {
                        $str = " 1 - 0 ";

                    } else if ($match[4] == 2) {
                        $str = " 0 - 1 ";
                    } else {
                        $str = " Erreur ";
                    }
                }
                ?><table><tr><th><input type="submit" id="_contest_" value="<?php echo $match[1], $str, $match[2],$bet?>"</th></tr></table><?php
            }
        } ?>
        <table><tr><th><button onclick="window.location.href='viewRunMatch.php';">Retour</button></th></tr></table></main></body><footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer></html>
<?php
} else {
    header('location: ../Guest_home.html');
}
