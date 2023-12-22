<?php
session_start();
require_once('../../ConnexionDataBase.php');
if ($_SESSION['captain'] == 1) {
$bdd = __init__();
$req = $bdd->prepare("SELECT name, firstname, username FROM Guests WHERE Team is null and isPlayer = true and isDeleted = false");
$req->execute();
$resultat = $req->fetchAll();
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
    <form action="../../Controller/Capitain/addPlayer.php" method='post'>

            <label><?php echo $result[2]?></label>
            <input id="add" type='submit' name="add_team_<?php echo $result[2]; ?>" value="+"/>

    </form>
            </td>

        </tr>
    <?php
}
?>
    </tbody>
</table>
    <div id="bouton">
        <button onclick="window.location.href='../Home/Home.php';" value="Home">Retour sur votre espace</button>
    </div>
</div>


</body>
<?php
} else {
    header('location: ../../Controller/Connect/CheckConnect.php');
}

