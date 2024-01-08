<?php
session_start();
require_once('../../ConnexionDataBase.php');
if ($_SESSION['captain'] == 0) {
    $bdd = __init__();
    $user = $_SESSION['username'];
    $req = $bdd->prepare("SELECT Team FROM request WHERE username=:user AND isplayerask = false");
    $req->bindValue(':user', $user, PDO::PARAM_STR);
    $req->execute();
    $resultat = $req->fetchAll();
    ?>
    <!DOCTYPE html>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="TeamRequest.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h3>Cette page sert à accepter les demandes pour rejoindre une équipe </h3>
    <?php
    if($resultat==null){
        ?>
        <p>il n'y a personne qui souhaite vous recruter dans son équipe pour le moment...</p>
        <?php
    }else{
        ?>
<div>
    <table>
        <thead>
        <tr>
            <th scope="col">Equipe</th>
            <th scope="col">Réponse</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($resultat as $result){
            ?>
            <tr>
                <td><?php echo $result[0]?></td>
                <td>
                    <form action="../../Controller/MemberAsk/Response_Request.php" method='post'>
                        <input id="response" type='submit' name="yes_<?php echo $result[0]; ?>" value="Accepter"/>
                        <input id="response" type='submit' name="no_<?php echo $result[0]; ?>" value="Refuser"/>
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
    }
    ?>
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