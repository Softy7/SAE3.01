<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="connexion.css" media="screen" type="text/css" />
    <title>Formulaire d'adhésion</title>
</head>
<body>
<div id="container">

<form action="../../Controller/Registering/checkInscription.php" method="post">
    <h1>Adhésion</h1>
    <?php echo $_SESSION['message']?>
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
</html>