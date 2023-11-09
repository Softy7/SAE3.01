<?php
session_start();
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../launch.php');

$user = launch();
$user = $user->deleteTeam();

header('location: ../../View/Capitain/Destroyed.php');

