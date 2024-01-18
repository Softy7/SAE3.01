<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="connexion.css" media="screen" type="text/css" />
    <title>Demande d'adhésion</title>
</head>
<body>
<div id="container">

<form action="../../Controller/Registering/checkInscription.php" method="post">
    <h1>Adhésion</h1>
    Nom: <input type="text" name="name"><br>
    Prenom: <input type="text" name="firstname"><br>
    Email: <input type="text" name="email"><br>
    date de naissance: <input type="date" name="birth"><br>
    identifiant: <input type="text" name="user">
    mot de passe: <input type="password" name="password"><br>
    Confirmer mot de passe: <input type="password" name="passwordC">

    <input type="submit" value="Demander Adhésion">
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