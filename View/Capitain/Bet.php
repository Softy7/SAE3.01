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
    $maxbet = $user->nextMatchBet($Matchs[0][6]);

    $bets=$user->getBet($bdd,$Matchs[0][0]);

    if ($bets == null || $bets[0][0] != $user->username){

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
</head>
<body>
<h1>Match: <?php echo $Matchs[0][1];?> - <?php echo $Matchs[0][2];?></h1>

<form action="../../Controller/Capitain/Bet.php" method="post">

    <label>Pari (max: <?php echo $maxbet ?>:</label>
    <input id="pari" type="number" name="pari">
    <input id="submit" type="submit" name="valider">

</form>
<button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">retour</button>
</body>
</html>
<?php
    }else{
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
</head>
<body>
    <h1>Pari rentré. <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?></h1>
    <button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">Retour</button>
</body>
</html>
<?php
    }
} else {
    header('location: ../Guest_Home.html');
}
?>