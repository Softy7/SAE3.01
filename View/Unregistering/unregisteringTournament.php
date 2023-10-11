<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UFT-8">
    <title>Desinscription Tournoi</title>
</head>
<body>
    <p>voulez-vous vous desinscrire du tournoi ?</p>
<form action="../../Controller/Unregistering/unregisteringTournament.php" method="post">
    <input type="submit" value="Oui">
</form>
<button onclick="window.location.href = '../../Controller/Connect/CheckConnect.php';">Non</button>

</body>
</html>
