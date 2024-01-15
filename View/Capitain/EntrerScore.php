<?php
session_start();
require_once("../../Controller/launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd=__init__();
$user = launch();
$team=$user->getTeam();
if ($_SESSION['connected']) {
    $resultats=$user->getMatchNotValidated($bdd);

    if ($resultats[0][1]=="$team"){
    ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Cholage Club Quaroule.fr</title>
        </head>
        <body>
        <h1>Entrer le score du match de <?php echo $resultats[0][1]; ?> contre <?php echo $resultats[0][2]; ?></h1>
        <form action="../../Controller/Capitain/EntrerScore.php" method="post">

            <label>Entrer le nombre de coup de déchole utilisé durant cette parti</label>
            <input id="nbdechole" type="number" name="nbdechole">
            <br>
            <label>coché la case si vous avez gagné </label>
            <input id="win" type="checkbox" name="win[]" value="teamWon"><br>


            <input id="submit" type="submit" name="valider" value="valider">

        </form>
        <br>
        <button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">retour</button>
        </body>
        </html>
        <?php
    }elseif($resultats[0][2]==$team && $resultats[0][3]==0){ ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Cholage Club Quaroule.fr</title>
        </head>
        <body>
        <h1>Le capitaine de l'équipe <?php echo $resultats[0][1]; ?> n'a pas encore entré les scores</h1>
        <br>
        <button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">retour</button>
        </body>
        </html>

    <?php
    } else{ ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Cholage Club Quaroule.fr</title>
        </head>
        <body>
        <h1>Valider le score du match de <?php echo $resultats[0][1]; ?> contre <?php echo $resultats[0][2]; ?> entrer par le capitaine de l'équipe <?php echo $resultats[0][1]; ?></h1>
        <form action="../../Controller/Capitain/EntrerScore.php" method="post">

            <label> Le capitaine de l'équipe <?php echo $resultats[0][1]; ?> a entré le score <?php echo $resultats[0][3]; ?> et a entré qu'il a <?php if ($resultats[0][4]==1) {echo "gagné";}else{echo "perdu";}?></label>


            <input id="submit" type="submit" name="correct" value="correct">
            <input id="submit" type="submit" name="Contestation" value="Contestation">

        </form>
        <br>
        <button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">retour</button>
        </body>
        </html>
<?php
    }

}
?>