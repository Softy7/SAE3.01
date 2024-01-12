<?php
session_start();
require_once('../../ConnexionDataBase.php');
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

$resultats = [];

foreach ($user->getTeams($db) as $equipe) {
    $resultats[] = $user->RelsultCalculation($db, $equipe);
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
    $meilleurAttaquant = null;
    $meilleurDefenseur = null;

    foreach ($resultats as $res) {
        if ($meilleurAttaquant === null || $res[2] > $meilleurAttaquant[2]) {
            $meilleurAttaquant = $res;
        }

        if ($meilleurDefenseur === null || $res[3] > $meilleurDefenseur[3]) {
            $meilleurAttaquant = $res;
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
                if($classement == 1){
                echo "'Roi du fut' : vainqueurs ";
                }
                if($result === $meilleurAttaquant){
                    echo "'Videur de fut' : Meilleurs attaquant ";
                }
                if($result === $meilleurDefenseur){
                    echo "'Gardien du fut' : Meilleurs Défenseur";
                } ?>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
