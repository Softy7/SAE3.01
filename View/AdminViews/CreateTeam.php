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
    <button id="classment" onclick="window.location.href='viewOldTournament.php'">Classements</button><h1>Espace Création d'équipe</h1><button id="profile" onclick="window.location.href='../Profile/viewProfile.php'"><?php echo "Pseudo: ", $_SESSION['username']?><br><?php echo "Equipe: ", $_SESSION['teamName']?><br><?php echo $_SESSION['view']?></button>
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
                        ?><th><button id="notActive">Espace Création d'équipe</button></th><?php
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
