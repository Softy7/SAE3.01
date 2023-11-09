<?php
session_start();
require_once("../launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');

$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');

$user = launch();
$teamName = $_POST['teamName'];

if (!$user->scearchName($teamName, $bdd)){
    if (!empty($_POST)) {
        foreach ($_POST as $key => $value) {
            if (!strpos($key, 'add_team_')) {
                $username = str_replace('add_team_', '', $key);
            }
        }
        $user->createTeam($teamName,$username,$bdd);
        echo "<script>alert('L\'équipe a été créée avec succès.');</script>";
        header("location: ../Connect/CheckConnect.php");
    }
} else {
    echo "<script>alert('L\'équipe existe déjà. Veuillez choisir un autre nom.');</script>";
    header("location: ../../View/CreateTeam/Form.php");
}
