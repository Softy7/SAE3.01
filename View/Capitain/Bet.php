<?php
session_start();
require_once("../../Controller/launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd=__init__();
$user = launch();

$req=$bdd->prepare("SELECT idmatch WHERE betteamkept = null AND attack=:equipeCap OR defend=:equipeCap");
$req->bindParam(':equipeCap',$user->username);
$resultats=$req->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
</head>
<body>
<h1>Parier pour le match de <?php echo '...'; ?></h1>

<form action="../../Controller/Capitain/Bet.php" method="post">

    <label>Entrer en combien de coup de déchole vous penser gagner,<br> le plus petit pari des deux capitaine définira l'équipe qui chole</label>
    <select>
    <?php
    foreach ($resultats as $res) {
    ?>
        <option><?php $res[0] ?></option>
    <?php } ?>
    </select>
    <input id="pari" type="number" name="pari">
    <input id="submit" type="submit" name="valider">

</form>
</body>