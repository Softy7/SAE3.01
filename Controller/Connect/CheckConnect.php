<?php
session_start();

require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\PlayerAdministrator.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Player.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Member.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Administrator.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Controller\launch.php');

//require_once permet de récuperer les fichiers une seul fois ce qui évite des problème de mémoire.

if (!$_SESSION['connected']) {
    $user = $_POST['id'];
    $password = $_POST['MDP'];
} else {
    $user = $_SESSION['username'];
    $password = $_SESSION['password'];
}

$bdd = new PDO ("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');

$request = $bdd->prepare("SELECT username, mail, name, firstname, birthday, password, isPlayer, isAdmin
                                FROM Guests 
                                WHERE username = :user 
                                  AND password = :password 
                                  AND isRegistering = false");//recherche le pseudo et mots de passe dans la base de donné et regarde si l'administrateur a accepter sa demande pour devenir membre
$request->bindValue(':user',$user);
$request->bindValue(':password',$password);
$request->execute();
$result = $request->fetchAll();

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
    $user = launch();

    if ($user instanceof PlayerAdministrator) {
        header("location: ../../View/Home/AdminPlayer.php");
    } else if ($user instanceof Administrator) {
        header("location: ../../View/Home/Admin.php");
    } else if ($user instanceof Player) {
        header("location: ../../View/Home/Playerr.php");
    } else if ($user instanceof Member) {
        header("location: ../../View/Home/Memberr.php");
    }
} else {
    header("location: ../../View/NotAccepted.html");
}
exit;
