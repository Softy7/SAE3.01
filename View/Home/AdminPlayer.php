<?php
session_start();

if ($_SESSION['isAdmin'] == 1 && $_SESSION['isPlayer'] == 1) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ChomeurCholeur.fr</title>
</head>
<body>
<p>Bienvenue sur votre espace Joueur ! Monsieur l'Administrateur <?php echo $_SESSION['username']?></p>
<form action="../Unregistering/unregisteringTournament.php" method="post">
    <input type="submit" value="Désinscription Tournoi"/>
</form>
<form action="../Unregistering/unregisteringWebsite.php" method="post">
    <input type="submit" value="Supprimer le compte"/>
</form>
<p><?php echo $_SESSION['open'];?></p>
<form action="../../Controller/Registering/RegisterOpen.php" method="post">
    <input type="submit" value="Ouvrir/Fermer Inscriptions" />
</form>
<form action="../../Controller/Connect/Deconnect.php" method="post">
    <input type="submit" value="Deconnexion" />
</form>
</body>
</html>
<?php
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ChomeurCholeur.fr</title>
    </head>
    <body>
    <h1>404 not found</h1>

    </body>
    </html>
<?php
}