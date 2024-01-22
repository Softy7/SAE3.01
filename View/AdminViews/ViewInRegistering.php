<?php
session_start();
require_once('../../ConnexionDataBase.php');
require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');

if ($_SESSION['isAdmin']) {

$user = launch();
$results = $user->getNotRegistrered();
$bdd = __init__();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="inRegistering.css" rel="stylesheet">
</head>
<body>
<button id="classment" onclick="window.location.href='viewOldTournament.php'">Classements</button><h1>Espace Adhésion</h1><button id="profile" onclick="window.location.href='../Profile/viewProfile.php'"><?php echo "Pseudo: ", $_SESSION['username']?><br><?php echo "Equipe: ", $_SESSION['teamName']?><br><?php echo $_SESSION['view']?></button>
<center><table id="head"><tr>
            <th><button onclick="window.location.href='../Home/Home.php'">Espace Principal</button></th><th>
            <?php if ($_SESSION['isAdmin']) {
                ?><th><button onclick="window.location.href='../AdminViews/viewRunMatch.php'">Espace Rencontres</button></th><th><?php
                if ($_SESSION['openn']) {
                    ?><th><button onclick="window.location.href='../../Controller/Registering/RegisterOpen.php'">Passer en Mode Tournoi</button><?php
                } else {
                    ?><button onclick="window.location.href='../../Controller/Registering/RegisterOpen.php'">Passer en Mode Préparation</button></th><?php
                    ?><th><button onclick="window.location.href='../AdminViews/TournamentView.php'">Espace Génération</button><?php
                }?></th>
                <th><button onclick="window.location.href='../AdminViews/viewAllMember.php'">Espace Membres</button></th>
                <th><button id="notActive">Espace Adhésions</button></th>
                <th><button onclick="window.location.href='../AdminViews/UnregisteredView.php'">Espace Réadhésion</button></th>
                <?php if ($user->enoughtPlayer()) {
                    ?><th><button onclick="window.location.href='../AdminViews/CreateTeam.php'">Espace Création d'équipe</button></th><?php
                }?>
            <?php } else {
                ?><th><button onclick="window.location.href='../MemberViewMatch/viewRunMatch.php'">Espace Rencontres</button></th><th><?php
            }?><th>
                <?php if (!$_SESSION['openn']) {
                if ($_SESSION['captain']) {
                ?><button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">Espace Tournoi</button></th>

        <?php
        }
        } else {
            if (!$_SESSION['captain'] && $_SESSION['teamName'] != null) {
                ?><th><button onclick="window.location.href='../Team/LeaveConfirm4.php'">Quitter l'équipe</button></th>
                <th><button onclick="window.location.href='../PlayerView/ViewTeam.php'">Espace Effectif</button></th>
                <?php
            }
            if ($_SESSION['captain'] == 1) {?>

                <th><button onclick="window.location.href='../Capitain/ViewRequest.php'">Espace Enrollement</button></th>
                <th><button onclick="window.location.href='../Capitain/NewPlayer.php'">Espace Demandes</button></th>
                <th><button onclick="window.location.href='../Capitain/Players.php'">Espace Effectif</button></th>
                <th><button onclick="window.location.href='../Capitain/DestroyTeam.php'">Dissoudre l'équipe</button></th><?php
            }
        }

        if ($_SESSION['teamName'] == null && $_SESSION['openn'] && $_SESSION['isPlayer']) {
            if ($user->ableToCreate()) {
                ?><th><button onclick="window.location.href='../CreateTeam/Form.php'">Devenir Capitaine</button></th><?php
            }
            ?><th><button onclick="window.location.href='../Registering/AskJoin.php'">Espace Intégration</button></th><?php
            ?><th><button onclick="window.location.href='../Registering/TeamRequest.php'">Espace Demandes</button></th><?php
            ?><th><button onclick="window.location.href='../Unregistering/unregisteringTournament.php'">Quitter le tournoi</button></th><?php
        } else if ($_SESSION['teamName'] == null && $_SESSION['openn']){
            ?><th><button onclick="window.location.href='../Registering/registeringTournament.php'">Rejoindre le tournoi</button></th><?php
        }
        if (($_SESSION['teamName'] == null) && !($user instanceof Administrator)) {
            ?><th><button onclick="window.location.href='../Unregistering/unregisteringWebsite.php'">Supprimer le compte</button></th><?php
        } else {
            if ($user instanceof Administrator) {
                if ($user->lenghtAdmin($bdd)>=1 && $_SESSION['teamName'] == null) {
                    ?><th><button onclick="window.location.href='../Unregistering/unregisteringWebsite.php'">Supprimer le compte</button></th><?php
                }
            }
        }?>
            <th><button onclick="window.location.href='../../Controller/Connect/Deconnect.php'">Déconnexion</button></th>
            <th></th>
        </tr></table></center><br>
<?php
if($results!=null){
    foreach ($results as $result){
?>
        <center><form action="../../Controller/AdminFunctions/isRegisteringCall.php" id="form" method='post'>
    <label><?php echo $result[0], " ", $result[1], " ", $result[2], " ", $result[3], " ", $result[4] ?></label>
    <input type='submit' name="accept_<?php echo $result[0]; ?>" value='Accepter'/>
    <input type='submit' name="refuse_<?php echo $result[0]; ?>" value='Refuser'/>
</form></center>
<?php
    }
}else{
?>
    <label>Il n'y a aucune demande d'adhésion pour le moment...</label>
    <?php
}
?>
</body>
<footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer>
    </html>
<?php
} else {
    header('location: ../Home/Home.php');

}
