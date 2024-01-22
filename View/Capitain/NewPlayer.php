<?php
session_start();
require_once('../../ConnexionDataBase.php');
require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');

if ($_SESSION['captain'] == 1) {
$bdd = __init__();
$user = launch();
$req = $user->getPlayerFree();
$team = $user->getTeam();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="NewPlayer.css" rel="stylesheet" type="text/css" />
</head>
<body>
<button id="classment" onclick="window.location.href='viewOldTournament.php'">Classements</button><h1>Espace Demandes</h1><button id="profile" onclick="window.location.href='../Profile/viewProfile.php'"><?php echo "Pseudo: ", $_SESSION['username']?><br><?php echo "Equipe: ", $_SESSION['teamName']?><br><?php echo $_SESSION['view']?></button>
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
                <th><button id="notActive">Espace Demandes</button></th>
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
        }else if ($_SESSION['teamName'] == null && $_SESSION['openn']){
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
<div id="form">
<table >
    <tbody>
<?php
if ($req == null) {
    ?><h3>Aucun joueur disponible</h3><?php
} else {
    ?><h3>Ces joueurs peuvent intégrer votre équipe:</h3><?php
}
foreach ($req as $result){
    ?>
        <tr >
            <td><?php echo $result[0], " ", $result[1], " ", $result[2], " ", $result[3], " ", $result[4]?></td>
            <td>
    <?php
    $reqAsk = $bdd->prepare("SELECT Team, isplayerask FROM request WHERE username = '$result[2]' AND team = '$team'");
    $reqAsk->execute();
    $res = $reqAsk->fetchAll();
    if($res==null){
    ?>
    <form action="../../Controller/Capitain/addPlayer.php" method='post'>
        <input id="add" type='submit' name="Ask_<?php echo $result[0]; ?>" value="Recruter"/>
    </form>
    <?php
    }else if(!$res[0][1]){
        echo "Vous avez déjà demander a recruter ce joueur";
    }else if($res[0][1]){
        echo "Ce joueur demande déjà à vous rejoindre";
        ?>
        <button onclick="window.location.href='ViewRequest.php';" id="PlayerRequest" value="Voir demande recru">Voir les Demandes d'enrollement</button>
        <?php
    }
    ?>
    </td>

        </tr>
    <?php
}
?>
    </tbody>
</table>
</div>


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
    header('location: ../../Controller/Connect/CheckConnect.php');
}

