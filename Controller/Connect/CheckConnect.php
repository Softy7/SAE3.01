<?php
session_start();
require_once('../../Model/Capitain.php');
echo 1;
require_once('../../Model/AdminCapitain.php');
echo 2;
require_once('../../Model/PlayerAdministrator.php');
echo 3;
require_once('../../Model/Player.php');
echo 4;
require_once('../../Model/Member.php');
echo 5;
require_once('../../Model/Administrator.php');
echo 6;
require_once('../../ConnexionDataBase.php');
echo 8;
require_once('../launch.php');
echo 9;
//require_once permet de récuperer les fichiers une seul fois ce qui évite des problème de mémoire.

if (!$_SESSION['connected']) {
    $user = $_POST['id'];
    $password = $_POST['MDP'];
} else {
    $user = $_SESSION['username'];
    $password = $_SESSION['password'];
}

$bdd = __init__();

$request = $bdd->prepare("SELECT username, mail, name, firstname, birthday, password, isPlayer, isAdmin, team
                                FROM Guests 
                                WHERE username = :user 
                                  AND password = :password 
                                  AND isRegistered = true
                                  AND isDeleted = false");//recherche le pseudo et mots de passe dans la base de donné et regarde si l'administrateur a accepter sa demande pour devenir membre et regarde si l'utilisateur ne s'est pas désinscrit au préalable
$request->bindValue(':user',$user);
$request->bindValue(':password',$password);
$request->execute();
$result = $request->fetchAll();

$request = $bdd->prepare("SELECT username, teamName
                                FROM capitain 
                                WHERE username = :user ");//recherche le pseudo et mots de passe dans la base de donné et regarde si l'administrateur a accepter sa demande pour devenir membre et regarde si l'utilisateur ne s'est pas désinscrit au préalable
$request->bindValue(':user',$user);
$request->execute();
$result1 = $request->fetchAll();

if ($result != null) {// si la requete ci-dessus a trouver un membre, joueur ou un administrateur
    $_SESSION['username'] = $result[0][0];
    $_SESSION['mail'] = $result[0][1];
    $_SESSION['name'] = $result[0][2];
    $_SESSION['firstname'] = $result[0][3];
    $_SESSION['birthday'] = $result[0][4];
    $_SESSION['password'] = $result[0][5];
    $_SESSION['isPlayer'] = $result[0][6];
    $_SESSION['isAdmin'] = $result[0][7];
    $_SESSION['connected'] = true;
    $_SESSION['teamName'] = $result[0][8];

    if ($result1 == null) {
        $_SESSION['captain'] = 0;
    } else {
        $_SESSION['captain'] = 1;
    }
    $user = launch();

    if ($user instanceof AdminCapitain) {
        $_SESSION['view'] = 'Espace Capitaine Administrateur';
    } else if ($user instanceof Capitain) {
        $_SESSION['view'] = 'Espace Capitaine';
    } else if ($user instanceof PlayerAdministrator) {
        $_SESSION['view'] = 'Espace Joueur Administrateur';
    } else if ($user instanceof Administrator) {
        $_SESSION['view'] = 'Espace Administrateur';
    } else if ($user instanceof Player) {
        $_SESSION['view'] = 'Espace Joueur';
    } else if ($user instanceof Member) {
        $_SESSION['view'] = 'Espace Membre';
    }
    header("location: ../../View/Home/Home.php");
} else if ($_SESSION['try']){
    header("location: ../../View/NotAccepted.html");
} else {
    header("location: ../../View/Guest_Home.html");
}
exit;
