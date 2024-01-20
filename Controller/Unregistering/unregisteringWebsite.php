<?php
session_start();

require_once('../../ConnexionDataBase.php');
include_once('../../Model/Member.php');
include_once('../../Model/Player.php');
require_once('../launch.php');

$user = launch();
if ($_SESSION['openn'] == 1) {
    $bdd = __init__();
    $user = launch();
    $test = $user->unregisterMember($bdd);
    if ($test == 1) {
        header("location: ../../View/Unregistering/AcceptedUnregisteringWebsite.php");
    } else {
        header("location: ../../View/Unregistering/DeclinedAdminUnregisteringWebsite.php");
    }
} else {
    header("location: ../../View/Unregistering/DeclinedUnregisteringWebsite.php");
} exit;