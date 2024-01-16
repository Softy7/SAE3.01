<?php
session_start();
require_once('../../ConnexionDataBase.php');
require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');

if ($_SESSION['isAdmin']) {

$user = launch();
$results = $user->getNotRegistrered();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="inRegistering.css" rel="stylesheet">
</head>
<body>
<h1><?php echo $_SESSION['view'] ?></h1>
<p>Monsieur <?php echo $_SESSION['username']?></p>
<center><table id="head"><tr>
            <?php if ($_SESSION['isAdmin']) {
                ?><th><?php
                if ($_SESSION['openn']) {
                    ?><button onclick="window.location.href='../../Controller/Registering/RegisterOpen.php'">Passer en Mode Tournoi</button><?php
                } else {
                    ?><button onclick="window.location.href='../../Controller/Registering/RegisterOpen.php'">Passer en Mode Préparation</button><?php
                }?></th>
                <th><button onclick="window.location.href='viewAllMember.php';" value="Home">Voir Membres</button></th>
                <th><button onclick="window.location.href='../Home/Home.php'">Espace Principal</button></th>
                <th><button onclick="window.location.href='../AdminViews/UnregisteredView.php'">Réadhésion Membre</button></th>
                <?php if ($user->enoughtPlayer()) {
                    ?><th><button onclick="window.location.href='../AdminViews/CreateTeam.php'">Création d'équipe</button></th><?php
                }?>
            <?php }?><th><?php if (!$_SESSION['openn']) {
                    ?><button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">Espace Tournoi</button><?php
                }?></th>
            <?php if ($_SESSION['captain'] == 1) {
                ?><th><button onclick="window.location.href='../Capitain/Players.php'">Vue Equipe</button></th><?php
            }
            else if ($_SESSION['openn']) {
                ?><th><button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">Quitter l'équipe</button></th><?php
            }
            if ($_SESSION['teamName'] == null && $_SESSION['openn']) {
                ?><th><button onclick="window.location.href='../Capitain/CreateTeam.php'">Devenir Capitaine</button></th><?php
                ?><th><button onclick="window.location.href='../Unregistering/unregisteringTournament.php'">Quitter le tournoi</button></th><?php
            }
            if ($_SESSION['openn'] && $_SESSION['teamName'] == null) {
                ?><th><button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">Supprimer le compte</button></th><?php
            }?>
            <th><button onclick="window.location.href='../../Controller/Connect/Deconnect.php'">Déconnexion</button></th>
            <th></th>
        </tr></table></center>
<h3>Cette page vous sert a accepter ou réfuter les demande d'adhésion</h3>
<?php
if($results!=null){
    foreach ($results as $result){
?>
<form action="../../Controller/AdminFunctions/isRegisteringCall.php" method='post'>
    <label><?php echo "Pseudo: ",$result[0], ", Mail: ", $result[1], ", Nom: ", $result[2], ", Prénom: ", $result[3], ", Date de naissance: ", $result[4] ?></label>
    <input type='submit' name="accept_<?php echo $result[0]; ?>" value='Accepter'/>
    <input type='submit' name="refuse_<?php echo $result[0]; ?>" value='Refuser'/>
</form>
<?php
    }
}else{
?>
    <label>Il n'y a aucune demande d'adhésion pour le moment...</label>
    <?php
}
?>
</body>
<?php
} else {
    header('location: ../Home/Home.php');

}
