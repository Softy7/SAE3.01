<?php
session_start();

require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Controller\launch.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../Model/Team.php');

$user = launch();
$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
if ($_SESSION['open'] == 'Inscriptions Ouvertes') {
    $user->setIsClosed($bdd);
    $_SESSION['open'] = 'Inscriptions Fermées';
    $_SESSION['openn'] = 0;
} else {
    $user->setIsOpen($bdd);
    $_SESSION['open'] = 'Inscriptions Ouvertes';
    $_SESSION['openn'] = 1;
}
sleep(2);
header('location: ../../View/Home/Home.php');
