<?php
session_start();

$_SESSION['username'] = null;
$_SESSION['mail'] = null;
$_SESSION['name'] = null;
$_SESSION['firstname'] = null;
$_SESSION['birthday'] = null;
$_SESSION['password'] = null;
$_SESSION['isPlayer'] = null;
$_SESSION['isAdmin'] = null;
$_SESSION['connected'] = null;

session_destroy();

header("location: ../../View/Guest_Home.html");