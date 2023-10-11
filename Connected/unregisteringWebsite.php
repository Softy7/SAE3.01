<?php
session_start();

include_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Member.php');
include_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Player.php');
require_once('launch.php');


$bdd = new PDO ("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
$user = launch();
$test = $user->unregisterMember($bdd);
if ($test == 1){
    $message="la désinscription a bien été effectuée";
}
else{
    $message="la désinscription n'a pas été effectuée";
}

echo'
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UFT-8">
    <title>Désinscription</title>
</head>
<body>
<h1>Fin désinscription, veuillez fermer le site.</h1>
<p>',$message,'</p>
</body>
</html>
    ';