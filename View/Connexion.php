<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Connection</title>
    <link rel="stylesheet" href="connexion.css" media="screen" type="text/css" />

</head>
<body>
<div id="container">
<form action="../Controller/Connect/CheckConnect.php" method="post">
  <h2><label>Connexion:</label></h2><br/>
  <label>Identifiant: </label>
  <input name="id" type="text" />

  <label>Mot de passe: </label>
  <input name="MDP" type="password" /><br />

  <input type="submit" value="Connexion" name="ok"/>
</form>
</div>
</body>
<footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer>
</html>

<?php
session_start();
$_SESSION['isAdmin'] = false;
$_SESSION['isPlayer'] = false;
$_SESSION['try'] = true;

$_SESSION['connected'] = false;