<?php
session_start();
require_once('../../ConnexionDataBase.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../Controller/launch.php');

$db=__init__();
$user = launch();

if ($_SESSION['connected']) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Quarouble Chôlage.fr</title>
        <link href="HomeTournaments.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <h1><?php echo $_SESSION['view'] ?></h1>
    <p>Bienvenue sur votre espace de Tournois! Monsieur <?php echo $_SESSION['username']?></p>
    <button onclick="window.location.href='../../Controller/Connect/CheckConnect.php'" id="retour">Retour</button>
    <form action="../../Controller/Connect/Deconnect.php" method="post">
        <input type="submit" value="Déconnexion" id="deconnexion"/>
    </form>
    <?php
    if ($_SESSION['teamName'] != null) {
        ?>
        <p><?php echo 'Vous êtes dans l\'équipe ', $_SESSION['teamName'];?></p>
    <?php
    }

    if($_SESSION['isPlayer']==1){
        ?>
        <?php
        if($_SESSION['captain']==1){ ?>
            <button onclick="window.location.href='../Capitain/Bet.php'" id="parier">Parier</button>
            <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">Résultat</button>
            <?php
        }
    }
    $results = $user->getMatchs($db);
    if ($_SESSION['isPlayer']!=1){
        foreach ($results as $res){
            if($res[4]==0){

        ?>
                <h1>Le match <?php echo $res[1]; ?> contre <?php echo $res[2]; ?> sur le parcour <?php echo $res[6]; ?> n'a pas encore été joué</h1>

    <?php }
            else{
                if($res[4]==1){
                    ?>

                                <h1>Le match <?php echo $res[1]; ?> contre <?php echo $res[2]; ?> sur le parcour <?php echo $res[6]; ?> a été joué<br>L'equipe qui été en attaque a gagné avec <?php echo $res[5]; ?> décholes</h1>
            <?php } else if ($res[4]==2){?>
                    <h1>Le match <?php echo $res[1]; ?> contre <?php echo $res[2]; ?> sur le parcour <?php echo $res[6]; ?> a été joué<br>L'equipe qui été en défence a gagné </h1>
                <?php }
            }
        }
    }
    if($_SESSION['isAdmin']==1) {
        ?>
        <button id="matchs" onclick="window.location.href='../AdminViews/viewMatch.php'">Rencontres</button>
            <?php
    }
    ?>
    </body>
    <button id="return" onclick="window.location.href='../../Controller/Connect/CheckConnect.php'">Retour</button>
    </html>
    <?php
} else {
    header('location: ../Guest_Home.html');
}