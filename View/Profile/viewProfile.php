<?php
session_start();
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../Controller/launch.php');
require_once('../../ConnexionDataBase.php');

$user = launch();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="viewProfile.css" media="screen" type="text/css" />
    <title>Demande d'adhésion</title>
</head>
<body>
<div id="container">
    <form action="../Home/Home.php">
        <h1>Profil</h1>
        Pseudo: <?php echo $user->username?><br>
        Nom: <?php echo $user->getName()?><br>
        Prenom: <?php echo $user->getFirstname()?><br><br>
        Email: <?php echo $user->getMail()?><br><br>
        Date de naissance: <?php echo $user->getBirthday()?><br><br>
        Equipe: <?php if ($user instanceof player || $user instanceof PlayerAdministrator) {echo $user->getTeam();} else {echo "Aucune";}?><br><br>
        Mot de passe: ******** <br><br>
        <input type="submit" value="Espace Principal">
    </form>
</div>
</body>
<footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer>
</html>