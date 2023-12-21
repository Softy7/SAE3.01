<?php
session_start();
if ($_SESSION['isAdmin'] == 1) {
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewMatch.css" rel="stylesheet">
</head>
<body>
<h1>Résultat Final Match</h1>
    <header><?php if ($_SESSION['match'][0][7] != 1) {echo "Cochez la case ''Buté'' si le fût a été touché par une des deux équipes. Rentrez également le nombre de coups de déchôles.";} else {
        echo "Entrez les scores des deux équipes et validez le score.";
        }?></header>

<table><tr><th><?php if ($_SESSION['match'][0][7] != 1) {echo "Chôle: ";} echo $_SESSION['match'][0][1]?></th><th><?php
if ($_SESSION['match'][0][7] == 1) {
    ?><form action="../../Controller/AdminFunctions/setMatchScore.php" method="post"><input type="number" name="T1" value="<?php echo $_SESSION['match'][0][9]?>">:<input type="number" name="T2" value="<?php echo $_SESSION['match'][0][10]?>">
    <input type="submit" value="Valider">
    </form><?php
} else {
    ?><form action="../../Controller/AdminFunctions/setMatchWinner.php" method="post">Buté: <input type="checkbox" name="Goal"> Coups de déchôles: <input type="number" name="Turn" value="<?php echo $_SESSION['match'][0][11]?>"><input type="submit" name="__Send__" value="Valider">
    </form><?php
}
    ?></th><th><?php  if ($_SESSION['match'][0][7] != 1) {echo "Déchôle: ";} echo $_SESSION['match'][0][2];?></th></tr></table>
<button onclick="window.location.href='../../Controller/Connect/CheckConnect.php';">Retour</button>
<?php
} else {
    header('location: ../Guest_home.html');
}
