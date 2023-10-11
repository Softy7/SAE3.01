<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UFT-8">
    <title>Desinscription du Site</title>
</head>
<body>
    <p>voulez-vous vous desincrire du site ?</p>
<form action="../../Controller/Unregistering/unregisteringWebsite.php" method="post">
    <input type="submit" value="Oui">
</form>
<button onclick="window.location.href = '../../Controller/Connect/CheckConnect.php';">Non</button>

</body>
</html>
