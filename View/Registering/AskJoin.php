<?php
session_start();
require_once('../../ConnexionDataBase.php');

if ($_SESSION['isPlayer']) {
    $user = $_SESSION['username'];
    $bdd = __init__();
    $req = $bdd->prepare("SELECT team, capitain.username, count(guests.username) FROM guests join capitain ON guests.team = capitain.teamname GROUP BY team, capitain.username HAVING count(guests.username) < 4 AND team IS NOT NULL ORDER BY team");
    $req->execute();
    $resultat1 = $req->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="AskJoin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h3>Cette page sert a voir les équipes auquelles vous pouvez demander a rejoindre.</h3>
<div>
<table>
    <thead>
    <tr>
        <th scope="col">Equipe</th>
        <th scope="col">Capitaine</th>
        <th scope="col">effectif</th>
        <th id="Bis" scope="col"></th>
    </tr>
    </thead>
    <tbody>
<?php
foreach ($resultat1 as $result){
    ?>
        <tr>
            <td><?php echo $result[0]?></td>
            <td><?php echo $result[1]?></td>
            <td><?php echo $result[2]?></td>
            <td>
                <?php
                $reqAsk = $bdd->prepare("SELECT Team, isplayerask FROM request WHERE username = '$user' AND team = '$result[0]'");
    $reqAsk->execute();
    $res = $reqAsk->fetchAll();
                if($res==null){
        ?>
        <form action="../../Controller/MemberAsk/AskJoin.php" method='post'>
            <input id="add" type='submit' name="Ask_<?php echo $result[1]; ?>" value="Demander a rejoindre"/>
        </form>
        <?php
                }else if($res[0][1]){
                    echo "vous avez dejà demandé a rejoindre cette équipe";
                }else if($res[0][1]==false){
                    echo "cette équipe vous propose déjà de la rejoindre";
                    ?>
                    <button onclick="window.location.href='TeamRequest.php';" id="teamRequest" value="Voir demande recru">Voir les Demandes de Recrutement</button>
                        <?php
                }
                ?>
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
