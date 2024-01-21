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

    $user = $_SESSION['username'];
    $isCap = $User->checkCapitain($user);
    $User = launch();
    $password = $_SESSION['password'];
}

$temp = $User->getUser($user);
echo $User->getUser($user);

if ($temp != null) {

    if ($User->checkPassword($password, $user)) {

        $_SESSION['username'] = $temp[0][0];
        $_SESSION['mail'] = $temp[0][1];
        $_SESSION['name'] = $temp[0][2];
        $_SESSION['firstname'] = $temp[0][3];
        $_SESSION['birthday'] = $temp[0][4];
        $_SESSION['password'] = $password;
        $_SESSION['isPlayer'] = $temp[0][6];
        $_SESSION['isAdmin'] = $temp[0][7];
        $_SESSION['connected'] = true;
        $_SESSION['teamName'] = $temp[0][10];

        $isCap = $User->checkCapitain($_SESSION['username']);
        $_SESSION['captain'] = $isCap;
        $User = launch();

        if ($User instanceof AdminCapitain) {
            $_SESSION['view'] = 'Capitaine Administrateur';
        } else if ($User instanceof Capitain) {
            $_SESSION['view'] = 'Capitaine';
        } else if ($User instanceof PlayerAdministrator) {
            $_SESSION['view'] = 'Joueur Administrateur';
        } else if ($User instanceof Administrator) {
            $_SESSION['view'] = 'Administrateur';
        } else if ($User instanceof Player) {
            $_SESSION['view'] = 'Joueur';
        } else if ($User instanceof Member) {
            $_SESSION['view'] = 'Membre';
        }
        header("location: ../../View/Home/Home.php");
    } else {
        header('location: ../../View/NotAccepted.html');
    }

} else if ($_SESSION['try']) {
    header('location: ../../View/NotAccepted.html');
} else {
    header("location: ../../View/Guest_Home.html");
}
exit;
