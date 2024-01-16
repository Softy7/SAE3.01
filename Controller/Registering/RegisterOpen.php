<?php
session_start();

require_once('../launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');
require_once('../../Model/Capitain.php');

$user = launch();
$bdd = __init__();
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
header('location: ../Connect/CheckConnect.php');
