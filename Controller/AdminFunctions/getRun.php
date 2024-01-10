<?php
session_start();
require_once ('../../Model/AdminCapitain.php');
require_once ('../../Controller/launch.php');
require_once ('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

foreach ($_POST as $key => $value) {
    if (!strpos($key, '_idRun_')) {
        $id = str_replace('_idRun_', '', $key);
        $match = $user->getMatchInRun($bdd, $id);
        $_SESSION["match"] = $match;
        $run = $user->getRun($bdd);
        $_SESSION['run'] = "Parcours non trouvé";
        foreach ($run as $r) {
            if ($r[0] == $id) {
                if ($r[6] == 0) {
                    $_SESSION['bet'] = "Penalty";
                } else {
                    $_SESSION['bet'] = "Pari Max: $r[6]";
                }
            }
        }
        header("location: ../../View/AdminViews/viewMatch.php");
    }
}