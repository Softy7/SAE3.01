<?php
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/PlayerAdministrator.php');
require_once('../../Model/Player.php');
require_once('../../Model/Member.php');
require_once('../../Model/Administrator.php');
require_once('../../ConnexionDataBase.php');
require_once('../launch.php');
require_once('../../Model/Connexion.php');

session_start();


//require_once permet de récuperer les fichiers une seul fois ce qui évite des problème de mémoire.
$User = new Connexion();

if (!($_SESSION['connected'])) {
    $user = $_POST['id'];
    $password = $_POST['MDP'];
} else {

    $isCap = $User->checkCapitain($_SESSION['username']);
    $User = launch();
    header("location: ../../View/Home/Home.php");
    exit;
}

$temp = $User->getUser($user);

if ($temp != null) {

    if ($User->checkPassword($password, $user)) {

        $_SESSION['username'] = $temp[0][0];
        $_SESSION['mail'] = $temp[0][1];
        $_SESSION['name'] = $temp[0][2];
        $_SESSION['firstname'] = $temp[0][3];
        $_SESSION['birthday'] = $temp[0][4];
        $_SESSION['password'] = $temp[0][5];
        $_SESSION['isPlayer'] = $temp[0][6];
        $_SESSION['isAdmin'] = $temp[0][7];
        $_SESSION['connected'] = true;
        $_SESSION['teamName'] = $temp[0][10];

        $isCap = $User->checkCapitain($_SESSION['username']);
        $_SESSION['captain'] = $isCap;
        $User = launch();

        if ($User instanceof AdminCapitain) {
            $_SESSION['view'] = 'Espace Capitaine Administrateur';
        } else if ($User instanceof Capitain) {
            $_SESSION['view'] = 'Espace Capitaine';
        } else if ($User instanceof PlayerAdministrator) {
            $_SESSION['view'] = 'Espace Joueur Administrateur';
        } else if ($User instanceof Administrator) {
            $_SESSION['view'] = 'Espace Administrateur';
        } else if ($User instanceof Player) {
            $_SESSION['view'] = 'Espace Joueur';
        } else if ($User instanceof Member) {
            $_SESSION['view'] = 'Espace Membre';
        }
        header("location: ../../View/Home/Home.php");
    } else {
        header('location: ../../View/NotAccepted.html');
    }

} else if ($_SESSION['try']) {
    header("location: ../../View/Guest_Home.html");
} else {
    header('location: ../../View/NotAccepted.html');
}
exit;
