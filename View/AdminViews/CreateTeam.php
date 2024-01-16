<?php

require_once('../../ConnexionDataBase.php');
require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../ConnexionDataBase.php');
session_start();

if ($_SESSION['isAdmin'] == 1) {
    $bdd = __init__();
    $user = launch();
    $results = $user->getPlayer($bdd);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Cholage Club Quaroule.fr</title>
        <link href="CreateTeam.css" rel="stylesheet" type="text/css" />
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
                    <?php if ($user->enoughtPlayer()) {
                        ?><th><button onclick="window.location.href='../Home/Home.php'">Espace Principal</button></th><?php
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
    <main>
    <div id="container">
    <form action="../../Controller/AdminFunctions/CreateTeam.php" method='post' name="createTeamForm">
        <label>Nom d'équipe : </label><input Type="text" name="nameTeam" required="required"/><br>
        <label>Capitaine : </label><select required="required" name="cap">
            <option value="">Choisissez</option><?php
            foreach ($results as $res){
                if ($res[3] == null){
                    ?>
                    <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                    <?php
                }
            }?></select><br>
        <label>Joueur 1 : </label><select required="required" name="Player1">
            <option value="">Choisissez</option><?php
            foreach ($results as $res){
                if ($res[3] == null){
                    ?>
                    <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                    <?php
                }
            }?></select><br>
        <label>Joueur 2 : </label><select required="required" name="Player2">
            <option value="">Choisissez</option><?php
            foreach ($results as $res){
                if ($res[3] == null){
                    ?>
                    <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                    <?php
                }
            }?></select><br>
        <label>Joueur 3 : </label><select name="Player3">
            <option value="">Non obligatoire</option><?php
            foreach ($results as $res){
                if ($res[3] == null){
                    ?>
                    <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                    <?php
                }
            }?></select><br>
        <input type="submit" value="Créer" name="ok"/>
    </form>
    </div>
    </main>
    <?php
    ?>
    </body>
    </html>
    <?php
} else {
    header('location: ../../Controller/Connect/CheckConnect.php');
}
