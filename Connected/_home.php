<?php

session_start();

require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\PlayerAdministrator.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Player.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Member.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Administrator.php');
require_once('launch.php');

$unregisteringTournamenthtml = 'unregisteringTournament.html';
$unregisteringTournamentphp = 'unregisteringTournament.php';
$unregisteringWebsitehtml = 'unregisteringWebsite.html';
$unregisteringWebsitephp = 'unregisteringWebsite.php';

$conn = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
$req = $conn->prepare("Select open from Inscription");
$req->execute();
$result = $req->fetchAll();

if ($result[0][0] == 1) {
    $open = 'Inscriptions Ouvertes';
} else {
    $open = 'Inscriptions Fermées';
}

$user = launch();

if ($user == null) {
    echo 'Error 422, Session is not initialized';
}
if ($user instanceof PlayerAdministrator) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ChomeurCholeur.fr</title>
</head>
<body>
<p>Bienvenue sur votre espace Joueur ! Administrateur <?php echo $user->username?></p>
<form action="unregisteringTournament.html" method="post">
<input type="submit" value="Désinscription Tournoi" name="DS" id="3"/>
</form>
<form method="post">
<input type="submit" value="Supprimer le compte" name="DS" id="2"/>
    <p><?php echo $open;?></p>
    <input type="submit" value="Ouvrir/Fermer Inscriptions" name="CINS" id="2"/>
</form>
</body>
</html>
<?php
} else if ($user instanceof Administrator) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ChomeurCholeur.fr</title>
</head>
<body>
<p>Bienvenue sur votre espace Administrateur !<?php echo $user->username?></p>
<form method="post">
    <input type="submit" value="Inscription Tournoi" name="ojA" id="3"/>
</form>
<form method="post">
    <input type="submit" value="Supprimer le compte" name="DS" id="2"/>
</form>
    <p><?php echo $open;?></p>
    <input type="submit" value="Ouvrir/Fermer Inscriptions" name="CINS1" id="2"/>
</body>
</html>
<?php
} else if ($user instanceof Player) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ChomeurCholeur.fr</title>
</head>
<body>
<p>Bienvenue sur votre espace Joueur !<?php echo $user->username?> </p>
<form action="unregisteringTournament.html" method="post">
    <input type="submit" value="Désinscription Tournoi" id="3"/>
</form>
<form action= "unRegisteringWebsite.html" method="post">
    <input type="submit" value="Supprimer le compte" name="DS" id="2"/>
</form>
</body>
</html>
<?php
} else if ($user instanceof Member) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ChomeurCholeur.fr</title>
</head>
<body>
<p>Bienvenue sur votre espace membre ! <?php echo $user->username?></p>
<form method="post">
<input type="submit" value="Devenir Joueur" name="oj" id="1"/>
</form>
<form action= "unRegisteringWebsite.html" method="post">
    <input type="submit" value="Supprimer le compte" name="DS" id="2"/>
</form>
</body>
</html>
<?php
}   else if ($user == null) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ChomeurCholeur.fr</title>
</head>
<body>
<p>Bienvenue sur votre espace null !</p>
<form method="post">
<input type="submit" value="Devenir NULL" name="0" id="1"/>
<button onclick="window.location.href = '422.php';">NULL 422 ENTITY 303</button>
</form>
</body>
</html>
<?php
}
function oj($user){
    echo 'Vous êtes inscrits en tant que joueur.';
    sleep(3);
    $user = launch();
    $user->becomePlayer(new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83'));
    $_SESSION['isPlayer'] = true;
    $user = launch();
    header("Refresh:2");
}

function ojA($user){
    echo 'Vous êtes inscrits en tant que joueur.';
    sleep(3);
    $user = launch();
    $user->becomePlayer(new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83'));
    $_SESSION['isPlayer'] = true;
    $user = launch();
    header("Refresh:2");
}
function DS() {
    echo 'Vous essayez de vous désinscrire du site alors que vous êtes administrateur. Echec de la tentative.';
    echo 'Vous devez pouvoir accéder à la base de donnée manuellement pour vous désinscrire.';
}

if(array_key_exists("oj", $_POST)) {
    oj($user);
}

if(array_key_exists("DS", $_POST)) {
    DS();
}

if(array_key_exists("ojA", $_POST)) {
    ojA($user);
}
if(array_key_exists("CINS", $_POST)) {
    if ($open == 'Inscriptions Ouvertes') {
        $user->setIsClosed($conn);
    } else {
        $user->setIsOpen($conn);
    }
    sleep(2);
    header("Refresh:0");
}
if(array_key_exists("CINS1", $_POST)) {
    if ($open == 'Inscriptions Ouvertes') {
        $user->setIsClosed($conn);
    } else {
        $user->setIsOpen($conn);
    }
    sleep(2);
    header("Refresh:0");
}
?>