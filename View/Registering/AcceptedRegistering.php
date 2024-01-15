<?php
session_start();
if ($_SESSION['connected'] == 1) {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UFT-8">
    <title>Inscription</title>
</head>
<body>
<h1>Inscription pour le tournois finalisée.</h1>
<p>Vous pouvez retourner sur votre espace Membre.</p>
<form action= "../../Controller/Connect/CheckConnect.php" method="post">
    <input type="submit" value="Retourner sur la page principale" name="" id="2"/>
</form>
</body>
</html>
<?php
} else {
    header("location: ../../Controller/Connect/CheckConnect.php");
}