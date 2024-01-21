<?php
require_once ('../../Model/AdminCapitain.php');
require_once ('../../ConnexionDataBase.php');
require_once ('../../Controller/launch.php');

session_start();
$user = launch();
$bdd = __init__();

$match = null;
foreach ($_POST as $key => $value) {
    if (!strpos($key, '_contest_')) {
        $id = str_replace('_contest_', '', $key);
        $match = $user->getOneMatch($bdd, $id);
        $_SESSION['OneMatch'] = $match;
    }
}

if ($_SESSION['isAdmin'] == 1 && $match != null) {
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="Winner.css" rel="stylesheet">
</head>
<body>
<h1>Résultat Final Match</h1>
    <center><header><?php if ($match[0][7] != 1) {echo "Cochez la case ''Buté'' si le fût a été touché par une des deux équipes.
     Rentrez également le nombre de coups de déchôles.";} else {
        echo "Entrez les scores des deux équipes et validez le score.";
        }?></header></center>
<div></div>
<table><tr><th><?php if ($match[0][7] != 1) {echo "Chôle: ";} echo $match[0][1]?></th><th><?php
if ($match[0][7] == 1) {
    ?><form action="../../Controller/AdminFunctions/setMatchScore.php" method="post"><input type="number" name="T1" id="T1" value="<?php echo $match[0][9]?>">:<input type="number" name="T2" value="<?php echo $match[0][10]?>">
    <input type="submit" value="Valider" id="confirmatematch">
    </form><?php
} else {
    ?><form action="../../Controller/AdminFunctions/setMatchWinner.php" method="post">Buté: <input type="checkbox" name="Goal" id="Goal"> Coups de déchôles: <input type="number" name="Turn" value="<?php echo $match[0][11]?>"><input type="submit" name="__Send__" id="__Send__" value="Valider">
    </form><?php
}
    ?><button onclick="window.location.href='viewMatch.php';">Espace Principal</button></th>
        <th><?php  if ($match[0][7] != 1) {echo "Déchôle: ";} echo $match[0][2];?></th></tr></table>
<footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer></html>
<?php
} else {
    header('location: ../../Controller/Connect/checkConnect.php');
}
