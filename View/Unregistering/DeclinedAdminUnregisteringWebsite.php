<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UFT-8">
    <title>Desinscription</title>
</head>
<body>
<h1>Fin desinscription.</h1>
<p>Desinscription non effectuee. Vous êtes le seul administrateur restant sur le site.</p>
<form action= "../../Controller/Connect/CheckConnect.php" method="post">
    <input type="submit" value="Retourner sur la page principale" name="" id="2"/>
</form>
</body>
</html>