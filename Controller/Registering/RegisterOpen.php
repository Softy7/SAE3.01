<?php
session_start();

require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Controller\launch.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\PlayerAdministrator.php');

$user = launch();
$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
if ($_SESSION['open'] == 'Inscriptions Ouvertes') {
    $user->setIsClosed($bdd);
    $_SESSION['open'] = 'Inscriptions Fermées';
} else {
    $user->setIsOpen($bdd);
    $_SESSION['open'] = 'Inscriptions Ouvertes';
}
sleep(2);
if ($user instanceof PlayerAdministrator) {
    header("location: ../../View/Home/AdminPlayer.php");
} else if ($user instanceof Administrator) {
    header("location: ../../View/Home/Admin.php");
}
