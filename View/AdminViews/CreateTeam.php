<?php
session_start();

require_once('../../ConnexionDataBase.php');
require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');

if ($_SESSION['isAdmin'] == 1) {
    $bdd = new PDO("pgsql:host=localhost;dbname=postgres", 'postgres', 'v1c70I83');
    $results = launch()->getPlayer(__init__());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
</head>
<body>
<h1>cette page sert a créer des équipes "de Force"</h1>
<form action="../../Controller/AdminFunctions/CreateTeam.php" method='post'>
    <label>Nom d'équipe : </label><input Type="text" value="nameTeam" required="required"/><br>
    <label>Capitaine : </label><select required="required" id="cap">
        <option value="">Choisissez</option><?php
        foreach ($results as $res){
            if ($res[3] == null){
                ?>
                <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                <?php
            }
        }?></select><br>
    <label>Joueur 1 : </label><select required="required" id="Player1">
        <option value="">Choisissez</option><?php
        foreach ($results as $res){
            if ($res[3] == null){
                ?>
                <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                <?php
            }
        }?></select><br>
    <label>Joueur 2 : </label><select required="required" id="Player2">
        <option value="">Choisissez</option><?php
        foreach ($results as $res){
            if ($res[3] == null){
                ?>
                <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                <?php
            }
        }?></select><br>
    <label>Joueur 3 : </label><select id="Player3">
        <option value="">Non obligatoire</option><?php
        foreach ($results as $res){
            if ($res[3] == null){
                ?>
                <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                <?php
            }
        }?></select><br>
    <input type="submit" value="Créer" name="ok"/>
</form>
<button onclick="window.location.href='../Home/Home.php';" value="Home">Retour sur votre espace</button>
</body>
</html>
<?php
} else {
    header('location: ../Guest_Home.html');
}
?>