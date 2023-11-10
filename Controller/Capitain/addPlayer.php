<?php
require_once('../launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
session_start();

$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');

$user = launch();

if (!empty($_POST)) {
    echo -1;
    foreach ($_POST as $key => $value) {
        echo 0;
        if (strpos($key, 'add_team_')!==false) {
            echo 1;
            $username = str_replace('add_team_', '', $key);
            $user->addPlayerInTeam(new Player($username, null, null, null, null, null, null));
            echo "<script>alert('Joueur ajouté avec succès.');</script>";
            sleep(1);
            header("location: ../../View/Capitain/NewPlayer.php");
        }
    }

}
