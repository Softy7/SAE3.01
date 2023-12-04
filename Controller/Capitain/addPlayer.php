<?php
require_once('../launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../ConnexionDataBase.php');
session_start();

$bdd = __init__();

$user = launch();

if (!empty($_POST)) {
    echo -1;
    foreach ($_POST as $key => $value) {
        echo 0;
        if (strpos($key, 'add_team_')!==false) {
            echo 1;
            echo $key;
            $username = str_replace('add_team_', '', $key);
            echo $username;
            $user->addPlayerInTeam($username);
            echo "<script>alert('Joueur ajouté avec succès.');</script>";
            sleep(1);
            header("location: ../../View/Capitain/NewPlayer.php");
        }
    }

}
