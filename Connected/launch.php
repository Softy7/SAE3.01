<?php

require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\PlayerAdministrator.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Player.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Member.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Administrator.php');
function launch(){
    $user = null;
    if ($_SESSION['isPlayer'] == 1 && $_SESSION['isAdmin'] == 1) {
        $user = new PlayerAdministrator($_SESSION['username'],
            $_SESSION['mail'], $_SESSION['name'],
            $_SESSION['firstname'], $_SESSION['birthday'],
            $_SESSION['password']);
    } else if ($_SESSION['isPlayer'] == 1) {
        $user = new Player($_SESSION['username'],
            $_SESSION['mail'], $_SESSION['name'],
            $_SESSION['firstname'], $_SESSION['birthday'],
            $_SESSION['password']);
    } else if ($_SESSION['isAdmin'] == 1) {
        $user = new Administrator($_SESSION['username'],
            $_SESSION['mail'], $_SESSION['name'],
            $_SESSION['firstname'], $_SESSION['birthday'],
            $_SESSION['password'], false);
    } else if ($_SESSION['username'] != null) {
        $user = new Member($_SESSION['username'],
            $_SESSION['mail'], $_SESSION['name'],
            $_SESSION['firstname'], $_SESSION['birthday'],
            $_SESSION['password'], false);
    }
    return $user;
}