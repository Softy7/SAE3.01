<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="../Unregistering/css.css" media="screen" type="text/css" />
<head>
    <meta charset="UFT-8">
    <title>Inscription Tournoi</title>
</head>
<body>
<center><div>
<h3>Inscription Tournoi</h3>
    <p>Voulez-vous vous inscrire au tournois?</p>
<form action="../../Controller/Registering/registeringTournament.php" method="post">
    <input type="submit" value="Oui">
</form>
<input type="submit" onclick="window.location.href = '../../Controller/Connect/CheckConnect.php';" value="Non">
    </div></center>
</body>
<footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer>
</html>
