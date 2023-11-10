<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UFT-8">
    <title>Inscription Tournoi</title>
</head>
<body>
    <p>Voulez-vous vous inscrire au tournois?</p>
<form action="../../Controller/Registering/registeringTournament.php" method="post">
    <input type="submit" value="Oui">
</form>
<button onclick="window.location.href = '../../Controller/Connect/CheckConnect.php';">Non</button>

</body>
</html>
