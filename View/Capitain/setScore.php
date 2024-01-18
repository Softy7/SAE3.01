<?php
session_start();
require_once("../../Controller/launch.php");
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');

$bdd=__init__();
$user = launch();
$team=$user->getTeam();
if ($_SESSION['captain']) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quarouble Chôlage.fr</title>
    <link href="Home.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1><?php echo $_SESSION['view'] ?></h1><?php

if ($_SESSION['connected']) {

    $nextMatch=$user->getMatchNotPlayed($bdd);
    $bets = $user->getBet($bdd, $nextMatch[0][0]);
    $run = $user->getRun($bdd, $nextMatch[0][6]);

    if ($nextMatch[0][4] == 0 or $nextMatch[0][4] == null) {
        if ($nextMatch[0][3] == null && $nextMatch[0][7] != 1 && (count($bets) == 0||$bets[0][0] != $user->username)) {?>
            <div class="LastMatch">
            <h2>Prochain Match: Pari Max: <?php echo $run[0][5]?></h2>
            <form action="../../Controller/Capitain/Bet.php" method="post">
                    <input type="submit" id="Match" value="<?php echo $nextMatch[0][1], " VS ", $nextMatch[0][2]; ?>">
                    <label for="bet"><input type="number" required name="bet" checked max="<?php echo $run[0][5];?>" value="Pari"></label>
                </form>
            </div><?php

        } else if ($team == $nextMatch[0][1] && $nextMatch[0][11] != 1){?>
            <div class="LastMatch">
            <h2>Résultat:</h2>
            <form action="../../Controller/Capitain/setScore.php" method="post">
            <input type="submit" value="<?php echo $nextMatch[0][1], " VS ", $nextMatch[0][2]; ?>">
            <?php if ($nextMatch[0][3] != null && $nextMatch[0][7] != 1 ) {?>
                <label for="dock">Docké: <input type="checkbox" name="dock"></label>
                <label for="score">Déchôles: Max: <?php echo $nextMatch[0][3], " ";?><input type="number" required checked max ="<?php echo $nextMatch[0][3]?>" name="score"></label>
            <?php }
            else if ($nextMatch[0][7] == 1) {?>
                <label for="attack"><input type="number" required  name="attack" value="0"></label>
                <label for="defend"><input type="number" required  name="defend" value="0"></label>
                <?php
            }
        }?>
        </form>
        </div><?php
    }

    if ($nextMatch[0][4] == 3 && $team == $nextMatch[0][2]) {?>
        <div class="LastMatch">
        <h2>Prochain Match: Pari Max: <?php echo $run[0][5]?> Votre Pari: <?php echo $bets[0][2]?></h2>
        <form action="../../Controller/Capitain/setScore.php" method="post">
        <input type="submit" value="<?php echo $nextMatch[0][1], " 1 - 0 ", $nextMatch[0][2]; ?>">
        <label for="confirm">Valider Score: <input type="checkbox" name="confirm"></label>
        </form><?php
    } else if ($nextMatch[0][4] == 4 && $team == $nextMatch[0][2]) {?>
        <div class="LastMatch">
        <h2>Prochain Match: Pari Max: <?php echo $run[0][5]?> Votre Pari: <?php echo $bets[0][2]?></h2>
        <form action="../../Controller/Capitain/setScore.php" method="post">
        <input type="submit" value="<?php echo $nextMatch[0][1], " 0 - 1 ", $nextMatch[0][2]; ?>">
        <label for="confirm">Valider Score: <input type="checkbox" name="confirm"></label>
        </form><?php
    } else if ($nextMatch[0][7] == 1 && $nextMatch[0][11] == 1 && $team == $nextMatch[0][2]) {?>
        <div class="LastMatch">
        <h2>Prochain Match: (Penalty)</h2>
        <form action="../../Controller/Capitain/setScore.php" method="post">
        <input type="submit" value="<?php echo $nextMatch[0][1], " ", $nextMatch[0][9]," - ", $nextMatch[0][10], " ",$nextMatch[0][2]; ?>">
        <label for="confirm">Valider Score: <input type="checkbox" name="confirm"></label>
        </form><?php
    } else if ($nextMatch[0][7] == 1 && $nextMatch[0][11] == 1 && $team == $nextMatch[0][1]){
        ?><p>Prochain match sur prochain parcours à venir... </p><?php
    }
}?>
        </div>
</body>
<footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer>
    </html>
    <?php
} else {
    header('location: ../../Controller/Connect/checkConnect');
}

?>