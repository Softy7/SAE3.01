<?php

session_start();
require_once('../../Model/AdminCapitain.php');
require_once('../../Controller/launch.php');
require_once('../../ConnexionDataBase.php');
$user = launch();
$bdd = __init__();

if ($_SESSION['isAdmin'] == 1) {

?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" type="text/css" href="../Unregistering/css.css">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
</head>
<body>
<center>
<div>
<h3>Réinitialisation des Joueurs:</h3>
    <p>La réinitialisation des joueurs comprend repassage en mode membre et destruction des équipes. Vous confirmez la suppression de tout ça ?</p>

<form action='../../Controller/AdminFunctions/deleteTournament.php' method="post">
    <input type='submit' name="deleteTournament" value="Réinitialiser">
</form>
<input type="submit" onclick="window.location.href='TournamentView.php'" value="Retour"></div></center>
</body>
    <footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
                Projet Réalisé dans le cadre de la SAE 3.01<br>
                Références:<br>
                Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
                A destination de: <br>
                Philippe Polet<br>-----</p></center></footer>
    </html>
<?php
}