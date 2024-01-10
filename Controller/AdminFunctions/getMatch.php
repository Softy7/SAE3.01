<?php
session_start();
require_once ('../../Model/AdminCapitain.php');
echo 0;
require_once ('../../Controller/launch.php');
echo 1;
require_once ('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

if (isset($_POST)) {
    echo 4;
    echo 5;
    foreach ($_POST as $key => $value) {
        if (strpos($key, '_contest_') !== false) {
            $match = str_replace('_contest_', '', $key);
            $match = $user->getOneMatch($bdd, $match);
            $_SESSION["match"] = $match;
            header("location: ../../View/AdminViews/Winner.php");
            echo 6;
        }
    }
}
echo "fail";
