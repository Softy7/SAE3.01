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
                <th><button onclick="window.location.href='../Home/Home.php';" value="Home">Espace Principal</button></th>
                <th><button onclick="window.location.href='../AdminViews/ViewInRegistering.php'">Voir Demandes d'Adhésion</button></th>
                <th><button onclick="window.location.href='../AdminViews/UnregisteredView.php'">Réadhésion Membre</button></th>
                <?php if ($user->enoughtPlayer()) {
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
</html>
    <?php
} else {
    header('location: ../Guest_Home.html');
}
?>
