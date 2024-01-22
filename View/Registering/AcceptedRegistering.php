<?php
session_start();
if ($_SESSION['connected'] == 1) {
?>
<!DOCTYPE html>
<html lang="fr">
    <link rel="stylesheet" href="../Unregistering/css.css" media="screen" type="text/css" />
<head>
    <meta charset="UFT-8">
    <title>Inscription</title>
</head>
<body>
<center>
<div>
<h1>Inscription Tournoi</h1>
<p>L'inscription est effectuée et validée. Vous pouvez retourner sur votre espace Membre.</p>
<form action= "../../Controller/Connect/CheckConnect.php" method="post">
    <input type="submit" value="Retourner sur la page principale" name="" id="2"/>
</form></div></center>
</body>
    <footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
                Projet Réalisé dans le cadre de la SAE 3.01<br>
                Références:<br>
                Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
                A destination de: <br>
                Philippe Polet<br>-----</p></center></footer>
</html>
<?php
} else {
    header("location: ../../Controller/Connect/CheckConnect.php");
}