<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Connection</title>

</head>
<body>
<form action="CheckConnect.php" method="post">
  <label>veuiller donner votre identifiant et mot de passe :</label><br />
  <label>identifiant: </label>
  <input name="id" type="text" />

  <label>mot de passe: </label>
  <input name="MDP" type="password" /><br />

  <input type="submit" value="Connection" name="ok"/>
</form>
</body>
</html>

<?php
session_start();
