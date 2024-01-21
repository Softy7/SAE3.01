<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="../Unregistering/css.css" media="screen" type="text/css" />
<head>
    <meta charset="UFT-8">
    <title>Validation Score</title>
</head>
<body>
<center>
<div>
<h1>Score validé</h1>
<p>Le score de la rencontre a été validé. Vous pouvez retourner sur la page des matchs.</p>
<form action= "viewRunMatch.php" method="post">
    <input type="submit" value="Retourner sur la page des matchs" id="2"/>
</form>
</div>
</center>
</body>
</html>
