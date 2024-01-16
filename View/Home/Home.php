<?php
session_start();
require_once('../../Model/Connexion.php');
require_once ('../../ConnexionDataBase.php');

$connect = new Connexion();
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
                <th><button onclick="window.location.href='../AdminViews/viewAllMember.php'">Voir Membres</button></th>
                <th><button onclick="window.location.href='../AdminViews/ViewInRegistering.php'">Voir Demandes d'Adhésion</button></th>
                <th><button onclick="window.location.href='../AdminViews/UnregisteredView.php'">Réadhésion Membre</button></th>
        <?php if ($connect->enoughtPlayer()) {
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
    <div class="sides">

        <span id="publications">
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
            $request = $bdd->prepare("SELECT * FROM articles ORDER BY datepublication DESC");
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
    <span id="parcours">
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


            $request = $bdd->prepare("SELECT * FROM run ORDER BY idrun");
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    echo "<div>";
                    echo htmlspecialchars($row['title'])."<br>";
                    echo "Image : <img src='" . $row['path'] . "'><br>";
                    echo "Point de départ: ".htmlspecialchars(($row['starterpoint']))."<br>";
                    echo "Point d'arrivée: ".htmlspecialchars(($row['finalpoint']))."<br>";
                    echo "Paris max: ".htmlspecialchars(($row['maxbet']))."<br>";
                    //echo "<textarea readonly='readonly' id='contenu_" . $row['idarticle'] . "' name='contenu_" . $row['idarticle'] . "'>" . htmlspecialchars($row['contenu']) . "</textarea><br>";
                    echo "</div>";
                }
            } else {
                echo "<br>Aucune publication trouvée...";
            }
        }
        ?>
    </span>
    </div>

    </body>
    </html>
    <?php
} else {
    header('location: ../Guest_Home.html');
}