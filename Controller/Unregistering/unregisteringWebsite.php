<?php
session_start();

include_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Member.php');
include_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Player.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Controller\launch.php');

$user = launch();
if ($_SESSION['openn'] == 1) {
    $bdd = new PDO ("pgsql:host=localhost;dbname=postgres", 'postgres', 'v1c70I83');
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