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
<center><div>
<h1>Score Refusé</h1>
<p>Le score de la rencontre n'a pas été validé. Un des deux score a mal été rempli. (Score inférieur à 0 ou non rempli...)</p>
<form action="viewRunMatch.php" method="post">
    <input type="submit" value="Retourner sur la page des matchs" id="2"/>
</form></div></center>
</body>
</html>

