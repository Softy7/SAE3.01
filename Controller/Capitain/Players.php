<?php
session_start();
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');
require_once('../launch.php');
$user = launch();

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'set_capitain_')!==false) {
            $username = str_replace('set_capitain_', '', $key);
            $user->chooseNewCapitain($username);
            header("location: ../Connect/CheckConnect.php");
        }
        if (strpos($key, 'remove_player_')!==false) {
            $username = str_replace('remove_player_', '', $key);
            $user0 = new Player($username, null, null, null, null, null, $_SESSION['teamName']);
            $user0->unsetTeam();
            header("location: ../../View/Capitain/Players.php");
        }
    }
}
