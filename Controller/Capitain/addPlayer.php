<?php
require_once('../launch.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\AdminCapitain.php');
require_once('../../Model/Capitain.php');
session_start();

$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');

$user = launch();

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'add_team_')!==false) {
            $username = str_replace('add_team_', '', $key);
            $user->updateTeam(new Player($username, null, null, null, null, null, null));
            echo "<script>alert('Joueur ajouté avec succès.');</script>";
            //header("location: ../../View/CreateTeam/NewPlayer.php");
        }
    }

}
