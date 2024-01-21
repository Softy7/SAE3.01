<?php
session_start();
if ($_SESSION['captain']) {?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="../Unregistering/css.css" media="screen" type="text/css" />
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
</head>
<body>
<center>
<div>
<h1>Dissoudre l'équipe</h1>
<p>Voulez vous dissoudre l'équipe ? Tous vos joueurs enregistés quitteront l'équipe et vous perdrez votre progression. (C'est très long...)</p>
<form action='../../Controller/Capitain/DestroyTeam.php' method="post">
    <input type='submit' value="Dissoudre">
</form>
<form action='../../Controller/Connect/CheckConnect.php' method="post">
    <input type='submit' value="Retour">
</form>
</div>
</center>
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
