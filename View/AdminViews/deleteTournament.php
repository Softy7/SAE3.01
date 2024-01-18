<?php

session_start();
require_once('../../Model/AdminCapitain.php');
require_once('../../Controller/launch.php');
require_once('../../ConnexionDataBase.php');
$user = launch();
$bdd = __init__();

if ($_SESSION['isAdmin'] == 1) {

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewAllMember.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>ATTENTION, voulez-vous vraiment supprimer les tournois? (équipes, joueurs, parcours, capitaines et matchs) :</h1>

<form action='../../Controller/AdminFunctions/deleteTournament.php' method="post">
    <input type='submit' name="deleteTournament" value="Supprimer les tournois">
</form>
</body>
<?php
}