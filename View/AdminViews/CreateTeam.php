<?php

require_once('../../ConnexionDataBase.php');
require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../ConnexionDataBase.php');
session_start();

if ($_SESSION['isAdmin'] == 1) {
    $bdd = __init__();
    $results = launch()->getPlayer($bdd);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Cholage Club Quaroule.fr</title>
    </head>
    <body>
    <h1>Cette page sert a créer des équipes "de Force"</h1>
    <form action="../../Controller/AdminFunctions/CreateTeam.php" method='post' name="createTeamForm">
        <label>Nom d'équipe : </label><input Type="text" name="nameTeam" required="required"/><br>
        <label>Capitaine : </label><select required="required" name="cap">
            <option value="">Choisissez</option><?php
            foreach ($results as $res){
                if ($res[3] == null){
                    ?>
                    <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                    <?php
                }
            }?></select><br>
        <label>Joueur 1 : </label><select required="required" name="Player1">
            <option value="">Choisissez</option><?php
            foreach ($results as $res){
                if ($res[3] == null){
                    ?>
                    <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                    <?php
                }
            }?></select><br>
        <label>Joueur 2 : </label><select required="required" name="Player2">
            <option value="">Choisissez</option><?php
            foreach ($results as $res){
                if ($res[3] == null){
                    ?>
                    <option value=<?php echo"$res[0]"?>><?php echo"$res[1] $res[2]" ?></option>
                    <?php
                }
            }?></select><br>
        <label>Joueur 3 : </label><select name="Player3">
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
    <?php
    ?>
    <button onclick="window.location.href='../Home/Home.php';" value="Home">Retour sur votre espace</button>
    </body>
    </html>
    <?php
} else {
    header('location: ../../Controller/Connect/CheckConnect.php');
}
