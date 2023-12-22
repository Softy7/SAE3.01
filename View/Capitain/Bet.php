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

    $req=$bdd->prepare("SELECT idmatch, attack, defend FROM Match WHERE (score = 0) AND (attack=:equipeCap OR defend=:teamCap) ORDER BY(idmatch)");
    $req->bindParam(':equipeCap',$team);
    $req->bindParam(':teamCap',$team);
    $req->execute();
    $resultats=$req->fetchAll();

    $req2=$bdd->prepare("SELECT * FROM bet WHERE (username=:cap) AND (idmatch=:idmatch)");
    $req2->bindParam(':cap',$user->username);
    $req2->bindParam(':idmatch',$resultats[0][0]);
    $req2->execute();
    $resultats2=$req2->fetchAll();

    if ($resultats2[0][0]==""){


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
</head>
<body>
<h1>Parier pour le match de <?php echo $resultats[0][1];?> contre <?php echo $resultats[0][2];?></h1>

<form action="../../Controller/Capitain/Bet.php" method="post">

    <label>Entrer en combien de coup de déchole vous penser gagner,<br> le plus petit pari des deux capitaine définira l'équipe qui chole</label>
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
    <h1>vous avez déjà parié pour le match de <?php echo $resultats[0][1]; ?> contre <?php echo $resultats[0][2]; ?></h1>
    <button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">retour</button>
</body>
</html>
<?php
    }
} else {
    header('location: ../Guest_Home.html');
}
?>