<?php

require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../ConnexionDataBase.php');
session_start();
if ($_SESSION['isAdmin'] == 1) {

    $db = __init__();
    $user = launch();
$results = $user->getMember($db, $_SESSION['username'])

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewAllMember.css" rel="stylesheet" type="text/css" />
</head>
<body>
<button id="classment" onclick="window.location.href='viewOldTournament.php'">Classements</button><h1>Espace Membres</h1><button id="profile" onclick="window.location.href='../Profile/viewProfile.php'"><?php echo "Pseudo: ", $_SESSION['username']?><br><?php echo "Equipe: ", $_SESSION['teamName']?><br><?php echo $_SESSION['view']?></button>
<center><table id="head"><tr>
            <th><button  onclick="window.location.href='../Home/Home.php'">Espace Principal</button></th><th>
            <?php if ($_SESSION['isAdmin']) {
                ?><th><button onclick="window.location.href='../AdminViews/viewRunMatch.php'">Espace Rencontres</button></th><th><?php
                if ($_SESSION['openn']) {
                    ?><th><button onclick="window.location.href='../../Controller/Registering/RegisterOpen.php'">Passer en Mode Tournoi</button><?php
                } else {
                    ?><button onclick="window.location.href='../../Controller/Registering/RegisterOpen.php'">Passer en Mode Préparation</button></th><?php
                    ?><th><button onclick="window.location.href='../AdminViews/TournamentView.php'">Espace Génération</button><?php
                }?></th>
                <th><button id="notActive">Espace Membres</button></th>
                <th><button onclick="window.location.href='../AdminViews/ViewInRegistering.php'">Espace Adhésions</button></th>
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
                if ($user->lenghtAdmin($db)>=1 && $_SESSION['teamName'] == null) {
                    ?><th><button onclick="window.location.href='../Unregistering/unregisteringWebsite.php'">Supprimer le compte</button></th><?php
                }
            }
        }?>
            <th><button onclick="window.location.href='../../Controller/Connect/Deconnect.php'">Déconnexion</button></th>
            <th></th>
        </tr></table></center>
<h1>Voici les membres inscrits au site :</h1>
<?php
echo "<table><tr id='players'><th>Pseudo</th><th>Nom</th><th>Prénom</th><th>Joueur</th><th>Son équipe</th><th>Fonction</th></tr>";
foreach ($results as $res){
    echo"<tr id='players'><td>$res[0]</td>";
    echo"<td>$res[1]</td>";
    echo"<td>$res[2]</td>";
    if ($res[3]) {
        echo"<td>oui</td>";
    }else{
        echo"<td>non</td>";
    }if ($res[3] != null) {
        echo"<td>$res[3]</td>";
    }else {
        echo"<td>Aucune</td>";
    }if ($res[4] != null) {
        echo"<td>Admin</td>";
    }else{
        ?>
        <td>
            <form action="ConfirmAdmin.php" method="post">
            <input type='submit' name="Upgrade_<?php echo $res[0]; ?>" value="Promouvoir">
            </form>
        </td>
        <?php
    }
    echo"</th>";
}
echo"</table>";
?>
<br>

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
    header('location: ../Guest_Home.html');
}
?>
