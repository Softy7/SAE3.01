<?php
session_start();
require_once('../../ConnexionDataBase.php');
if ($_SESSION['captain'] == 1) {
$bdd = __init__();
$req = $bdd->prepare("SELECT name, firstname, username FROM Guests WHERE Team is null and isPlayer = true");
$req->execute();
$resultat = $req->fetchAll();
$team = $_SESSION['teamName']
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="NewPlayer.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h3>Cette page sert à ajouter des joueurs dans votre équipe. Veuillez sélectionner les joueurs que vous souhaitez ajouter</h3>
<div>
<table>
    <thead>
    <tr>
        <th scope="col">Nom</th>
        <th scope="col">Prénom</th>
        <th scope="col">Pseudo</th>
    </tr>
    </thead>
    <tbody>
<?php
foreach ($resultat as $result){
    ?>
        <tr>
            <td><?php echo $result[0]?></td>
            <td><?php echo $result[1]?></td>
            <td>
    <?php
    $reqAsk = $bdd->prepare("SELECT Team, isplayerask FROM request WHERE username = '$result[2]' AND team = '$team'");
    $reqAsk->execute();
    $res = $reqAsk->fetchAll();
    if($res==null){
    ?>
    <form action="../../Controller/Capitain/addPlayer.php" method='post'>
        <input id="add" type='submit' name="Ask_<?php echo $result[2]; ?>" value="recruter"/>
    </form>
    <?php
    }else if(!$res[0][1]){
        echo "Vous avez déjà demander a recruter ce joueur";
    }else if($res[0][1]){
        echo "Ce joueur demande déjà a vous rejoindre";
        ?>
        <button onclick="window.location.href='ViewRequest.php';" id="PlayerRequest" value="Voir demande recru">Voir les Demandes d'enrollement</button>
        <?php
    }
    ?>
    </td>
            </td>

        </tr>
    <?php
}
?>
    </tbody>
</table>
    <div id="bouton">
        <!--met le en dessous le bouton-->
        <button onclick="window.location.href='../Home/Home.php';" value="Home">Retour sur votre espace</button>
    </div>
</div>


</body>
<?php
} else {
    header('location: ../../Controller/Connect/CheckConnect.php');
}

