<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Formulaire d'adhésion</title>
</head>
<body>
<h1>Adhésion</h1>
<form action="../../Controller/Registering/checkInscription.php" method="post">
    Nom: <input type="text" name="name"><br>
    Prenom: <input type="text" name="firstname"><br>
    Email: <input type="text" name="email"><br>
    date de naissance: <input type="date" name="birth"><br>
    identifiant: <input type="text" name="user">
    mot de passe: <input type="password" name="password"><br>
    Confirmer mot de passe: <input type="password" name="passwordC">

    <input type="submit" value="Demander Adhésion">
</form>
</body>
</html>