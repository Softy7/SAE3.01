<?php
session_start();
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../launch.php');
require_once('../../ConnexionDataBase.php');



$user = launch();
$user = $user->deleteTeam($_SESSION['teamName']);

header('location: ../../View/Capitain/Destroyed.php');

