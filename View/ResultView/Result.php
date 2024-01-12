<?php
session_start();
require_once('../../ConnexionDataBase.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../Model/Administrator.php');
require_once('../../Model/Player.php');
require_once('../../Model/PlayerAdministrator.php');
require_once('../../Model/Member.php');
require_once('../../Controller/launch.php');

$db = __init__();
$user = launch();

function compareEquipes($equipe1, $equipe2) {
    if ($equipe1[1] != $equipe2[1]) {
        return $equipe2[1] - $equipe1[1];
    }

    if ($equipe1[2] != $equipe2[2]) {
        return $equipe2[2] - $equipe1[2];
    }

    return $equipe2[3] - $equipe1[3];
}

foreach ($user->getTeams($db) as $team) {
    $resultats[] = $user->RelsultCalculation($db, $team[0]);
}

usort($resultats, 'compareEquipes');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quarouble Chômage.fr</title>
</head>
<body>
<H1>Résultat Finaux</H1>

<table>
    <tr>
        <th>classement</th>
        <th>Equipe</th>
        <th>Total Victoires</th>
        <th>Victoires Attaque</th>
        <th>Victoires Défense</th>
        <th>Distinction</th>
    </tr>
    <?php $classement = 1;
    $meilleursAttaquants = [];
    $meilleursDefenseurs = [];

    foreach ($resultats as $res) {
        if (empty($meilleursAttaquants) || $res[2] > $meilleursAttaquants[0][2]) {
            $meilleursAttaquants = [$res];
        } elseif ($res[2] == $meilleursAttaquants[0][2]) {
            $meilleursAttaquants[] = $res;
        }

        if (empty($meilleursDefenseurs) || $res[3] > $meilleursDefenseurs[0][3]) {
            $meilleursDefenseurs = [$res];
        } elseif ($res[3] == $meilleursDefenseurs[0][3]) {
            $meilleursDefenseurs[] = $res;
        }
    }
    foreach ($resultats as $result) { ?>
        <tr>
            <td><?= $classement++ ?></td>
            <td><?= $result[0] ?></td>
            <td><?= $result[1] ?></td>
            <td><?= $result[2] ?></td>
            <td><?= $result[3] ?></td>
            <td>
                <?php
                if($classement == 2){
                    echo "|Roi du fut ";
                }
                if(in_array($result, $meilleursAttaquants)){
                    echo "|Videur de fut ";
                }
                if(in_array($result, $meilleursDefenseurs)){
                    echo "|Gardien du fut ";
                } ?>
            </td>
        </tr>
    <?php } ?>
</table>
<h4>index :</h4>
<p>Roi du fut = vainqueurs <br/>
    Videur de fut = Meilleurs attaquant<br/>
    Gardien du fut = Meilleurs Défenseur<br/></p>
</body>
</html>
