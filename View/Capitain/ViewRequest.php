<?php
session_start();
require_once('../../ConnexionDataBase.php');
if ($_SESSION['captain'] == 1) {
    $bdd = __init__();
    $user = $_SESSION['username'];
    $team = $_SESSION['teamName'];
    $req = $bdd->prepare("SELECT username FROM request WHERE team=:team AND isplayerask = true");
    $req->bindValue(':team', $team, PDO::PARAM_STR);
    $req->execute();
    $resultat = $req->fetchAll();
    ?>
    <!DOCTYPE html>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewResquest.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h3>Cette page sert à accepter les demandes des joueurs qui veulent rejoindre votre équipe </h3>
<?php
if($resultat==null){
    ?>
    <p>il n'y a personne qui souhaite rejoindre votre équipe pour le moment...</p>
    <?php
}else{
?>
<div>
    <table>
        <thead>
        <tr>
            <th scope="col">Joueur</th>
            <th>Réponse</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($resultat as $result){
            ?>
            <tr>
                <td><?php echo $result[0]?></td>
                <td>
                    <form action="../../Controller/Capitain/Response_Request.php" method='post'>
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