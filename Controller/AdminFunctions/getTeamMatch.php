<?php
session_start();
require_once ('../../Model/AdminCapitain.php');
require_once ('../../Controller/launch.php');
require_once ('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

foreach ($_POST as $key => $value) {
    if (!strpos($key, '_teamName_')) {
        $tn = str_replace('_teamName_', '', $key);
        if(!strpos($key, '_')) {
            $tn = str_replace('_', ' ', $tn);
        }
        $_SESSION['tname'] = $tn;
        $match = $user->getMatch($bdd, $tn);
        $_SESSION["match"] = $match;
        header("location: ../../View/AdminViews/viewTeamMatch.php");
    }
}
echo "fail";
