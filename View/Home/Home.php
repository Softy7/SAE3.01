<?php
session_start();
require_once('../../ConnexionDataBase.php');

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
    <h1><?php echo $_SESSION['view'] ?></h1>
    <p>Bienvenue sur votre espace ! Monsieur <?php echo $_SESSION['username']?></p>
    <form action="../../Controller/Connect/Deconnect.php" method="post">
        <input type="submit" value="Déconnexion" id="deconnexion"/>
    </form>
    <button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'" id="ModeTournois">Mode Tournois</button>
    <?php
    if ($_SESSION['teamName'] != null) {
    ?>
    <p id="nomEquipe"><?php echo 'Vous êtes dans l\'équipe ', $_SESSION['teamName'];?></p>
    <?php
    }

    if ($_SESSION['isAdmin'] == 1) {
        if ($_SESSION['lenght'] > 1) {
            echo "<form action='../Unregistering/unregisteringWebsite.php' method='post'>
                    <input type='submit' value='Supprimer le compte' id='del'/>
                    </form>";
        } else {
            echo "<p><div id='boite'>Vous ne pouvez pas<br> vous désincrire car vous êtes <br>le seul administrateur du site</div></p>";
        }
    }else{
        echo "<form action='../Unregistering/unregisteringWebsite.php' method='post'>
                    <input type='submit' value='Supprimer le compte' id='del'/>
                    </form>";
    }

    if ($_SESSION['openn'] == 1) {

        if ($_SESSION['isPlayer'] != 1) {
            echo "<form action='../Registering/registeringTournament.php' method='post'>
            <input type='submit' value='Inscription Tournoi' id='championship'/>
            </form>";
        } else {
            echo "<form action='../Unregistering/unregisteringTournament.php' method='post'>
            <input type='submit' value='Désinscription Tournoi' id='championship'/>
            </form>";

            if ($_SESSION['captain'] != 1) {
                if ($_SESSION['teamName'] != null) {
                    ?>
                    <!--bouton ci-dessous à modifier-->
                    <button onclick="window.location.href='../CreateTeam/Form.php';" id="viewTeam" value="Voir Equipe">Voir Equipe</button>
                    <?php
                    ?>
                    <button onclick="window.location.href='../Team/LeaveConfirm4.php';" id="leave" value="Quitter Equipe">Quitter Equipe</button>
                    <?php
                }
                else {
            ?>
            <button onclick="window.location.href='../CreateTeam/Form.php';" value="Créer Equipe" id="CreateTeam">Créer une équipe</button>
            <?php
                }
            } else {
                ?>
                <form action='../Capitain/DestroyTeam.php' method="post">
                    <input type='submit' value="Dissoudre l'équipe" id="deleteTeam">
                </form>
                <form action='../Capitain/NewPlayer.php' method="post">
                    <input type='submit' value="Recruter un joueur" id="addPlayerTeam">
                </form>
                <?php

            ?>
                <form action='../Capitain/Players.php' method="post">
                    <input type='submit' value="Voir effectif" id="viewTeam">
                </form>
                <?php
            }
        }
    }
        if ($_SESSION['isAdmin'] == 1) {
            ?>
            <button onclick="window.location.href='../AdminViews/viewAllPlayer.php';" value="ViewPlayer" id="ViewPlayer">Voir les joueurs</button>
            <?php
            if ($_SESSION['openn'] == 1) {
                echo "<form action='../../Controller/Registering/RegisterOpen.php' method='post'>
            <input type='submit' value='Fermer Inscriptions' id='boutonEtatInscription'/>
            </form>";
            } else {
                echo "<form action='../../Controller/Registering/RegisterOpen.php' method='post'>
            <input type='submit' value='Ouvrir Inscriptions' id='boutonEtatInscription'/>
            </form>";
            }
            ?>
            <form action="../AdminViews/ViewInRegistering.php" method="post">
                <input type="submit" value="Voir Demande Adhesion" id="voirAdhesion"/>
            </form>
            <form action="../AdminViews/ArticlesEdit.php" method="post">
                <input type="submit" value="Gérer Publications" id="gererPublication"/>
            </form>

            <form action="../AdminViews/UnregisteredView.php" method="post">
                <input type="submit" value="Voir désinscrits" id="viewUnregistered"/>
            </form>
            <form action="../AdminViews/UnregisteredView.php" method="post">
                <input type="submit" value="gérer parcours" id="gererParcours"/>
            </form>
            <button onclick="window.location.href='../AdminViews/CreateTeam.php';" value="CreateByForce" id="CreateByForce">Création forcée d'équipe</button>
            <?php
        }
    ?>
    <p id="etatInscription"><?php echo $_SESSION['open'];?></p>
    <div id="publications">
        <h2>Actualités:</h2>
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
                    echo "<textarea readonly='readonly' id='contenu_" . $row['idarticle'] . "' name='contenu_" . $row['idarticle'] . "'>" . htmlspecialchars($row['contenu']) . "</textarea><br>";
                    echo "</div>";
                }
            } else {
                echo "Aucune publication trouvée...";
            }
        }
        ?>
    </div>

    </body>
    </html>
    <?php
} else {
    header('location: ../Guest_Home.html');
}