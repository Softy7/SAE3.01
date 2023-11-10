<?php
require_once('../../Model/Player.php');
require_once('../../Model/PlayerAdministrator.php');
require_once('../launch.php');
require_once('../../ConnexionDataBase.php');
session_start();
$user = launch();
$user->unsetTeam();
header('location: ../../View/Team/LeaveConfirm.php');