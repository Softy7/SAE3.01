<?php
session_start();
if ($_SESSION['captain']) {?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="" rel="stylesheet">
</head>
<body>
<h1>Dissoudre l'équipe</h1>
<p>Voulez vous dissoudre l'équipe ? Tous vos joueurs enregistés quitteront l'équipe et vous perdrez votre progression. (C'est très long...)</p>
<form action='../../Controller/Capitain/DestroyTeam.php' method="post">
    <input type='submit' value="Dissoudre">
</form>
<form action='../../Controller/Connect/CheckConnect.php' method="post">
    <input type='submit' value="Retour">
</form>
</body>
<?php
} else {
header('location: ../Guest_Home.html');
}
