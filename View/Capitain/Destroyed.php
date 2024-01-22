<?php
session_start();
if ($_SESSION['captain']) {?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="../Unregistering/css.css" rel="stylesheet">
</head>
<body>
<center>
<div>
<h1>Dissoudre l'équipe</h1>
<p>L'équipe a été dissoute. Veuillez retourner à l'accueil.</p>
<form action='../../Controller/Connect/CheckConnect.php' method="post">
    <input type='submit' value="Retour">
</form></div></center>
</body>
<footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer>
<?php
} else {
    header('location: ../Guest_Home.html');
}