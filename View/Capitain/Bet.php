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

    $Matchs=$user->getMatchNotPlayed($bdd);


    $bets=$user->getBet($bdd,$Matchs[0][0]);

    if($bets[0][0]=="" || $bets[0][0]!= $user->username && $bets[1][0]==""){
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Cholage Club Quaroule.fr</title>
        </head>
        <body>
        <h1>Parier pour le match de <?php echo $Matchs[0][1];?> contre <?php echo $Matchs[0][2];?></h1>

        <form action="../../Controller/Capitain/Bet.php" method="post">

            <label>Entrer en combien de coup de déchole vous penser gagner,<br> le plus petit pari des deux capitaine définira l'équipe qui chole</label>
            <input id="pari" type="number" name="pari">
            <input id="submit" type="submit" name="valider">

        </form>
        <button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">retour</button>
        </body>
        </html>

    }else{
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
</head>
<body>
    <h1>vous avez déjà parié <?php if(bets[0][0]==$user->username){echo $bets[0][2];} else{echo $bets[1][2];}?> pour le match de <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?></h1>
    <button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">retour</button>
</body>
</html>
<?php
    }
} else {
    header('location: ../Guest_Home.html');
}
?>