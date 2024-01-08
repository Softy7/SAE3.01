<?php
require_once('../../ConnexionDataBase.php');
require_once('../launch.php');
require_once('../../Model/AdminCapitain.php');
session_start();
$bdd = __init__();
if (isset($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'Upgrade_') !== false) {
            $username = str_replace('Upgrade_', '', $key);
            launch()->upgradeMember($bdd, $username);
        }
    }
}
header("location: ../../View/AdminViews/viewAllMember.php");