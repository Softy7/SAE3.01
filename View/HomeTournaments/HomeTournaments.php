<?php
session_start();

require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');
require_once("../../Controller/launch.php");

$bdd = __init__();


if ($_SESSION['connected']) {
    $user = launch();
    $nextMatch = array();
    if ($user instanceof Capitain || $user instanceof AdminCapitain) {
        $nextMatch = $user->getMatchNotPlayed($bdd);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Quarouble Chôlage.fr</title>
        <link href="HomeTournaments.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <button id="classment" onclick="window.location.href='viewOldTournament.php'">Classements</button><h1>Chôlage Quarouble</h1><button id="profile" onclick="window.location.href='../Profile/viewProfile.php'"><?php echo "Pseudo: ", $_SESSION['username']?><br><?php echo "Equipe: ", $_SESSION['teamName']?><br><?php echo $_SESSION['view']?></button>
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
                    ?><button id="notActive">Espace Tournoi</button></th>

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
    <?php if(count($nextMatch) > 0) {
        ?>
        <div class="LastMatch">
        <h2>Prochain Match:</h2>
            <form action="../Capitain/setScore.php">
            <input type="submit" id="Match" value="<?php echo $nextMatch[0][1]; if ($nextMatch[0][4] == 3) {echo " 1 - 0 ";} else if ($nextMatch[0][4] == 4) {echo " 0 - 1 ";} else if ($nextMatch[0][7] == 1) {echo " ", $nextMatch[0][9], " - ", $nextMatch[0][10], " ";}  else if ($nextMatch[0][4] == 0 ) {echo " VS ";} echo $nextMatch[0][2];?>">
            </form>
        <h2>Matchs à venir: </h2>
            <?php
            for ($i = 1; $i < count($nextMatch); $i++) {
                $run = $user->getRun($bdd, $nextMatch[$i][6])
                ?>
                    <p><?php echo "Parcours: ", $run[0][1], " Pari Max: ", $run[0][5], " Point de départ: ", $run[0][3], " Point d'arrivée: ", $run[0][4] ?></p>
                <input type="submit" id="Match" value="<?php echo $nextMatch[$i][1], " VS ", $nextMatch[$i][2]; ?>">
            <?php
            }
            ?>
        </div>
        <?php
    } else {
        echo 'Aucun match à venir existant pour le moment... Veuillez patienter.';
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
    header('location: ../Guest_Home.html');
}