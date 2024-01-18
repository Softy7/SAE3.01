<?php

require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

session_start();

$user = launch();
if ($_SESSION['isAdmin'] == 1) {

    $bdd = __init__();
    $run = $user->getRun($bdd);
    $match = $user->getMatch($bdd);

    ?><!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset=UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewMatch.css" rel="stylesheet">
</head>
<body>
<button id="classment" onclick="window.location.href='viewOldTournament.php'">Classements</button><h1>Espace Génération Tournoi</h1><button id="profile" onclick="window.location.href='../Profile/viewProfile.php'"><?php echo "Pseudo: ", $_SESSION['username']?><br><?php echo "Equipe: ", $_SESSION['teamName']?><br><?php echo $_SESSION['view']?></button>
<center><table id="head"><tr>
            <th><button onclick="window.location.href='../Home/Home.php'">Espace Principal</button></th><th>
            <?php if ($_SESSION['isAdmin']) {
                ?><th><button onclick="window.location.href='../AdminViews/viewRunMatch.php'">Espace Rencontres</button></th><th><?php
                if ($_SESSION['openn']) {
                    ?><th><button onclick="window.location.href='../../Controller/Registering/RegisterOpen.php'">Passer en Mode Tournoi</button><?php
                } else {
                    ?><button onclick="window.location.href='../../Controller/Registering/RegisterOpen.php'">Passer en Mode Préparation</button></th><?php
                    ?><th><button id="notActive">Espace Génération</button><?php
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
<br>
    <?php

    if ($match == null) {
        $teams = count($user->getTeams($bdd));
        $cruns = count($user->getRun($bdd));
    ?><table><tr><th><form action="deleteTournament.php" method="post">
                <input type="submit" name="final" value="Réinitialiser Joueurs">
            </form></th></tr></table><?php
        if (($teams%2 == 0)&&($cruns>0)) {?>
            <table><tr><th><form action="../../Controller/AdminFunctions/TournamentTreatment.php" method="post">
                <input type="submit" name="generate" value="Générer Tournoi">
            </form></th></tr></table><main>
            <?php
        } else {
            ?>
            <table><tr><th>Génération Impossible. <?php echo $teams, " Equipes et ", $cruns, " Parcours présents."?></th></tr></table><main>
            <?php
        }
    } else if ($user->checkMatchs()&&$user->EditionCheck($bdd)){?>
                <table><tr><th><form action="../ResultView/Result.php" method="post">
            <input type="submit" name="destroy" value="Clôturer Tournoi">
            </form></th></tr></table><?php
    } else {
        ?>
        <table><tr><th><form action="../../Controller/AdminFunctions/TournamentTreatment.php" method="post">
            <input type="submit" name="destroy" value="Détruire Tournoi">
            </form></th></tr></table><main>
        <?php
        }
        foreach ($run as $r) {
            ?>
            <table><tr><th>Parcours: <?php echo $r[1]?></th></tr></table>
            <?php
            foreach ($match as $m) {
                if ($m[6] == $r[0]) {
                    if ($m[4] == 1) {
                        ?><table><tr><th><input type="submit" id="correct" value="<?php echo $m[1], " 1 - 0 ", $m[2], ' Pari:',$m[3], ' Coups:', $m[11]?>"></th></tr></table><?php
                    } else if ($m[4] == 2) {
                        ?><table><tr><th><input type="submit" id="correct" value="<?php echo $m[1], " 0 - 1 ", $m[2], ' Pari:',$m[3], ' Coups:',$m[11]?>"</th></tr></table><?php
                    } else if ($m[7] != null && $m[9] != null && $m[10]!=null) {
                        ?><table><tr><th><input type="submit" id="correct" value="<?php echo $m[1], ' ', $m[9]," - ", $m[10], ' ', $m[2]?>"</th></tr></table><?php
                    } else {
                        ?><table><tr><th><input type="submit" id="correct" value="<?php echo $m[1], " - ", $m[2]?>"</th></tr></table><?php
                    }
                }
            }
        }
        ?></main></body>
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
