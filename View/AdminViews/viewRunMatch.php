<?php
session_start();
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Controller/launch.php');
require_once('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

if ($user instanceof Administrator) {
$run = $user->getRun($bdd);
$teams = $user->getTeams($bdd);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewRunMatch.css" rel="stylesheet">
</head>
<body>
<button id="classment" onclick="window.location.href='viewOldTournament.php'">Classements</button><h1>Espace Rencontres</h1><button id="profile" onclick="window.location.href='../Profile/viewProfile.php'"><?php echo "Pseudo: ", $_SESSION['username']?><br><?php echo "Equipe: ", $_SESSION['teamName']?><br><?php echo $_SESSION['view']?></button>
<center><table id="head"><tr>
            <th><button onclick="window.location.href='../Home/Home.php'">Espace Principal</button></th><th>
            <?php if ($_SESSION['isAdmin']) {
                ?><th><button id="notActive">Espace Rencontres</button></th><th><?php
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
                <th><button onclick="window.location.href='../Capitain/NewPlayer.php'">Espace Demandes</button></th>
                <th><button onclick="window.location.href='../Capitain/Players.php'">Espace Effectif</button></th>
                <th><button onclick="window.location.href='../Capitain/DestroyTeam.php'">Dissoudre l'équipe</button></th><?php
            }
        }

        if ($_SESSION['teamName'] == null && $_SESSION['openn'] && $_SESSION['isPlayer']) {
            if ($user->ableToCreate()) {
                ?><th><button onclick="window.location.href='../Capitain/CreateTeam.php'">Devenir Capitaine</button></th><?php
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
        </tr></table></center>
<center><h1>Liste parcours & équipes:</h1></center>
<div class="main">
    <span>
<table><?php
    if ($run == null) {
        ?><tr><th>Aucun parcours n'existe... Veuillez créer un parcours afin de créer une rencontre.</th></tr><?php
    } else {
        ?><form action="../../Controller/AdminFunctions/getRun.php" method="post"><?php

        foreach ($run as $r) {
            ?><tr><th><input type="submit" name="_idRun_<?php echo $r[0]?>" value="<?php echo "Parcours: ", $r[1]; if ($r[5] == 0) { echo " Penalty";} else { echo " Pari Max: ", $r[6];} ?>"></th></tr><?php
        }
        ?><?php
    }
    ?></form></table></span>


    <span><table><?php
    if ($teams == null) {
        ?><tr><th>Aucune équipe n'est présente. Pas de match possible.</th></tr><?php
    } else {
    ?><form action="../../Controller/AdminFunctions/getTeamMatch.php" method="post">
        <?php

        foreach ($teams as $t) {
            ?><tr><th><input type="submit" id="_teamName_" name="_teamName_<?php echo $t[0]?>" value="<?php echo $t[0]?>"></th></tr><?php
        }
        ?><?php
    }
                ?></form></table></span>
</div></body><footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer></html>

    <?php
} else {
    header('location: ../MemberViewMatch/viewRunMatch.php');
}