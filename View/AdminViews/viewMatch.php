<?php
require_once ('../../Model/AdminCapitain.php');
require_once ('../../Controller/launch.php');
require_once ('../../ConnexionDataBase.php');

$user = launch();

$matchs = $user->getMatch(__init__(), null);

?>