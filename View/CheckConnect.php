<?php
session_start();

require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\PlayerAdministrator.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Player.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Member.php');
require_once('C:\Users\ewanr\PhpstormProjects\SAE3.01\Model\Administrator.php');

$user = $_POST['id'];
$password = $_POST['MDP'];

$bdd = new PDO ("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');

$request = $bdd->prepare("SELECT username, mail, name, firstname, birthday, password, isPlayer, isAdmin
                                FROM Guests 
                                WHERE username = '$user' 
                                  AND password = '$password' 
                                  AND isRegistering = false");
$request->execute();
$result = $request->fetchAll();

if ($result != null) {
    $_SESSION['username'] = $result[0][0];
    $_SESSION['mail'] = $result[0][1];
    $_SESSION['name'] = $result[0][2];
    $_SESSION['firstname'] = $result[0][3];
    $_SESSION['birthday'] = $result[0][4];
    $_SESSION['password'] = $result[0][5];
    $_SESSION['isPlayer'] = $result[0][6];
    $_SESSION['isAdmin'] = $result[0][7];

    header("location: ../Connected/_home.php");
    exit;
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ChômeurCholeur.fr</title>
</head>
<body>
<h3>Identifiant ou mot de passe incorect, il se peut aussi que l'administrateur n'ait pas encore accepté votre inscription</h3>
<button onclick="window.location.href ='Home_Page.html';">Accueil</button>
<button onclick="window.location.href ='connection.html';">Réessayer</button>
</body>
</html>
<?php
}