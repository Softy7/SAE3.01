<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Connection</title>

</head>
<body>
<form action="../Controller/Connect/CheckConnect.php" method="post">
  <label>veuiller donner votre identifiant et mot de passe :</label><br />
  <label>identifiant: </label>
  <input name="id" type="text" />

  <label>mot de passe: </label>
  <input name="MDP" type="password" /><br />

  <input type="submit" value="Connexion" name="ok"/>
</form>
</body>
</html>

<?php
session_start();
$_SESSION['isAdmin'] = false;
$_SESSION['isPlayer'] = false;


$_SESSION['connected'] = false;