<?php
session_start();
require_once('../../ConnexionDataBase.php');
require_once('../../Model/AdminCapitain.php');
require_once('../launch.php');

require_once('../../ConnexionDataBase.php');
require_once('../../Model/AdminCapitain.php');
require_once('../launch.php');

$TeamName = $_POST['nameTeam'];
$Captain = $_POST['cap'];
$Player1 = $_POST['Player1'];
$Player2 = $_POST['Player2'];
$Player3 = $_POST['Player3'];

if (($Captain == $Player1 or $Captain == $Player2 or $Captain == $Player3)or($Player1 == $Player2 or $Player1==$Player3)or($Player2==$Player3)) {

}


$bdd = __init__();

$user = launch();

    if ($Captain == $user->username) {
        $_SESSION['teamName'] = $TeamName;
        $_SESSION['view'] = 'Capitaine Administrateur';
    }

    $user->createTeamF($TeamName, $Captain, $bdd);
    $user->addPlayerF($TeamName, $Player1);
    $user->addPlayerF($TeamName, $Player2);

    if ($Player3 != null) {
        $user->addPlayerF($TeamName, $Player3);
    }
    echo "<script>alert('L\'équipe a été créée avec succès.');</script>";
    header("location: ../../View/AdminViews/CreateTeam.php");
}
