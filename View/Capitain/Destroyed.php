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
<p>L'équipe a été dissoute. Veuillez retourner à l'accueil.</p>
<form action='../../Controller/Connect/CheckConnect.php' method="post">
    <input type='submit' value="Retour">
</form>
</body>
<?php
} else {
    header('location: ../Guest_Home.html');
}