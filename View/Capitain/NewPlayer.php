<?php
session_start();
if ($_SESSION['captain'] == 1) {
$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
$req = $bdd->prepare("SELECT username FROM Guests WHERE Team is null");
$req->execute();
$resultat = $req->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
</head>
<body>
<h3>Cette page sert à ajouter des joueurs dans votre équipe. Veuillez sélectionner les joueurs que vous souhaitez ajouter</h3>
<?php
foreach ($resultat as $result){
    ?>
    <form action="../../Controller/Capitain/addPlayer.php" method='post'>
        <label><?php echo "Pseudo: ",$result[0]?></label>
        <input type='submit' name="add_team_<?php echo $result[0]; ?>" value="+"/>
    </form>
    <?php
}
?>
</body>
<?php
} else {
    header('location: ../../Controller/Connect/CheckConnect.php');
}

