<?php
session_start();

require_once('../../Model/Member.php');
require_once('../../Model/Player.php');
require_once('../../Model/PlayerAdministrator.php');
require_once('../launch.php');

$user = launch();
if ($_SESSION['openn'] == 1) {
    $bdd = new PDO("pgsql:host=localhost;dbname=postgres", 'postgres', 'v1c70I83');
    $user = launch();
    $user = $user->unsetPlayer($bdd);
    $_SESSION['isPlayer'] = false;

    header('location: ../../View/Unregistering/AcceptedUnregistering.php');
} else  {
    header('location: ../../View/Unregistering/DeclinedUnregistering.php');
}