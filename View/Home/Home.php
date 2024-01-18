<?php
session_start();
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once ('../../Controller/launch.php');
require_once ('../../ConnexionDataBase.php');

$user = launch();
$bdd = __init__();

if ($_SESSION['connected']) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Quarouble Chôlage.fr</title>
        <link href="Home.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <button id="classment" onclick="window.location.href='viewOldTournament.php'">Classements</button><h1>Espace Principal</h1><button id="profile" onclick="window.location.href='../Profile/viewProfile.php'"><?php echo "Pseudo: ", $_SESSION['username']?><br><?php echo "Equipe: ", $_SESSION['teamName']?><br><?php echo $_SESSION['view']?></button>
    <center><table id="head"><tr>
                <th><button id="notActive">Espace Principal</button></th><th>
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
    <h1>Actus & Parcours</h1>
    <div class="sides">
        <span id="articles">
            <table id="runArticle"><tr><th><h2>Actualités:</h2></th>
                <?php if ($_SESSION['isAdmin'] == 1) {echo
                    '<form action="../AdminViews/ArticlesEdit.php" method="post">
            <th><input type="submit" value="Gérer Publications" id="gererPublication"/></th>
        </form>';
                }
        ?></tr></table>
            <?php
        $bdd = __init__();

        if (!$bdd) {
            echo "Erreur de connexion à la base de données.";
        } else {
            $request = $bdd->prepare("SELECT * FROM articles ORDER BY datepublication");
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    echo "<div>";
                    echo htmlspecialchars($row['title'])."<br>";
                    echo "date: " . $row['datepublication'] . "<br>";
                    echo "Auteur: ".htmlspecialchars(($row['writer']))."<br>";
                    echo "<h4>";
                    echo "". htmlspecialchars($row['contenu']) . "<br>";
                    echo "</h4>";
                    echo "</div>";
                }
            } else {
                echo "<br>Aucune publication trouvée...";
            }
        }
        ?>
    </span>
    <span id="runs">
        <table id="runArticle"><tr><th><h2>Parcours:</h2></th>
                <?php if ($_SESSION['isAdmin'] == 1) {echo
                    '<form action="../AdminViews/RunView.php" method="post">
                <th><input type="submit" value="Gérer parcours" id="gererParcours"/></th>
            </form>';
                }
                ?></tr></table>
        <?php

        if (!$bdd) {
            echo "Erreur de connexion à la base de données.";
        } else {


            $request = $bdd->prepare("SELECT * FROM run ORDER BY orderrun");
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    echo "<div>";
                    echo htmlspecialchars($row['title'])."<br>";
                    echo "Image : <img src='" . $row['image_data'] . "'><br>";
                    echo "Point de départ: ".htmlspecialchars(($row['starterpoint']))."<br>";
                    echo "Point d'arrivée: ".htmlspecialchars(($row['finalpoint']))."<br>";
                    echo "Paris max: ".htmlspecialchars(($row['maxbet']))."<br>";
                    //echo "<textarea readonly='readonly' id='contenu_" . $row['idarticle'] . "' name='contenu_" . $row['idarticle'] . "'>" . htmlspecialchars($row['contenu']) . "</textarea><br>";
                    echo "</div>";
                }
            } else {
                echo "<br>Aucun parcours trouvé...";
            }
        }
        ?>
    </span>
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
    header('location: ../Guest_Home.html');
}