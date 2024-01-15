<?php
session_start();
require_once('../../ConnexionDataBase.php');
require_once('../launch.php');
require_once('../../Model/AdminCapitain.php');

$user = launch();
$bdd = __init__();

if (isset($_POST['deleteTournament'])) {
    $user->deleteTournament($bdd);
    echo 'Tournoi supprimé';
}
?>
    <button onclick="window.location.href='../../View/Home/Home.php';" value="Home">Retour à l'Accueil</button>
    </body>
<?php