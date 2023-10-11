<?php
session_start();

require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Member.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Player.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\PlayerAdministrator.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Controller\launch.php');

$user = launch();
if ($_SESSION['openn'] == 1) {
    $bdd = new PDO("pgsql:host=localhost;dbname=postgres", 'postgres', 'v1c70I83');
    $user = launch();
    $user = $user->becomePlayer($bdd);
    $_SESSION['isPlayer'] = true;
    header('location: ../../View/Registering/AcceptedRegistering.php');
} else {
    header('location: ../../View/Registering/DeclinedRegistering.php');
}