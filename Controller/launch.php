<?php

require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\PlayerAdministrator.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Player.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Member.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Administrator.php');
function launch(){
    $conn = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
    $req = $conn->prepare("Select open from Inscription");
    $req->execute();
    $result = $req->fetchAll();

    if ($result[0][0] == 1) {
        $_SESSION['open'] = 'Inscriptions Ouvertes';
        $_SESSION['openn'] = true;
    } else {
        $_SESSION['open'] = 'Inscriptions Fermees';
        $_SESSION['openn'] = false;
    }

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