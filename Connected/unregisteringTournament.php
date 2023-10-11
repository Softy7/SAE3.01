<?php
session_start();

include_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Member.php');
include_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Player.php');
include_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\PlayerAdministrator.php');
require_once('launch.php');


$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
$user = launch();
$user = $user->unsetPlayer($bdd);
$_SESSION['isPlayer'] = false;
if ($user instanceof Player != 1 || $user instanceof PlayerAdministrator != 1){
    $message="la désinscription du tournois a bien été effectuée";
}
else{
    $message="la désinscription du tournois n'a pas été effectuée";
}

echo'
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UFT-8">
    <title>Désinscription</title>
</head>
<body>
<h1>Désinscription du tournois finalisée.</h1>
<p>',$message,'. Vous pouvez retourner sur votre espace Membre.</p>
<form action= "_home.php" method="post">
    <input type="submit" value="Retourner sur la page principale" name="" id="2"/>
</form>
</body>
</html>
';