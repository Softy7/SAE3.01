<?php
require_once('../launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../ConnexionDataBase.php');
session_start();

$bdd = __init__();

$user = launch();

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'add_team_')!==false) {
            $username = str_replace('add_team_', '', $key);
            $user->addPlayerInTeam($username);
            echo "<script>alert('Joueur ajouté avec succès.');</script>";
            sleep(1);
            header("location: ../../View/Capitain/NewPlayer.php");
        }
    }

}
