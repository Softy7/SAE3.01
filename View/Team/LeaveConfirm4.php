<?php
session_start();
if ($_SESSION['connected']) {?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Cholage Club Quaroule.fr</title>
        <link href="" rel="stylesheet">
    </head>
    <body>
    <h1>Quitter l'équipe</h1>
    <p>Voulez vous quitter l'équipe ? Vous perdrez votre progression. (C'est très long...)</p>
    <form action='../../Controller/TeamGuy/Leave.php' method="post">
        <input type='submit' value="Quitter">
    </form>
    <form action='../../Controller/Connect/CheckConnect.php' method="post">
        <input type='submit' value="Retour">
    </form>
    </body>
    <?php
} else {
    header('location: ../Guest_Home.html');
}
