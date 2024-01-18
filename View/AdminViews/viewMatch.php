<?php
session_start();
require_once('../../Model/AdminCapitain.php');
require_once('../../Controller/launch.php');
require_once('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

if ($user instanceof Administrator && $_SESSION['run'] != null) {
$run = $_SESSION['run'];
$matchs = $_SESSION['match'];
$bet = $_SESSION['bet'];
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
<center><h1>Gestion Matchs Parcours: <?php echo $run, ' ',$bet?></h1></center>
</header>
<main>
<?php
    if ($matchs == null) {
        ?>
    <t>Aucune rencontre n'est définie...</t>
    <?php
    } else {
        foreach($matchs as $match) {
            if ($match[8] != 1) {
                if ($match[4] == 1) {
                    ?><table><tr><th><input type="submit" id="correct" value="<?php echo $match[1], " 1 - 0 ", $match[2], ' Pari: ',$match[3], ' Coups: ', $match[11]?>"></th></tr></table><?php
                } else if ($match[4] == 2) {
                    ?><table><tr><th><input type="submit" id="correct" value="<?php echo $match[1], " 0 - 1 ", $match[2], ' Pari: ',$match[3], ' Coups: ',$match[11]?>"</th></tr></table><?php
                } else if ($match[7] != null && $match[9] != null && $match[10] != null) {
                    ?><table><tr><th><input type="submit" id="correct" value="<?php echo $match[1], ' ', $match[9]," - ", $match[10], ' ', $match[2]?>"</th></tr></table><?php
                } else {
                    ?><table><tr><th><input type="submit" id="correct" value="<?php echo $match[1], " - ", $match[2]?>"</th></tr></table><?php
                }
            } else {
                $contests[] = $match;
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
</main>
</body><footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer>
</html><?php
} else if ($user instanceof Administrator) {
    header('location: viewRunMatch.php');
} else {
    header('location: ../Guest_home.html');
}
