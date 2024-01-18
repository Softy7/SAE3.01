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

if ($user instanceof Administrator && $user->checkMatchs() && $user->EditionCheck($db)) {
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
    <link rel="stylesheet" href="Result.css" media="screen" type="text/css" />
</head>
<body>
<H1>&#x1F3C6; Résultat Finaux &#x1F3C6;</H1>
<div id="google_translate_element"></div>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'fr',
            includedLanguages: 'en,fr',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');
    }
</script>

<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<table>
    <tr>
        <th>Classement</th>
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
    if($user->EditionCheck($db)){
        foreach ($resultats as $r){
            $user->SaveTournament($db, $classement, $r[0]);
            $classement++;
        }
        $classement=1;
    }
    foreach ($resultats as $result) { ?>
        <tr>
            <td id="class"><?php
                if($classement == 1){
                    ?>&#129351;<?php
                }
                if($classement == 2){
                ?>&#129352;<?php
                }
                if($classement == 3){
                ?>&#129353;<?php
                }
                if($classement>=4){
                    echo $classement;
                }
                $classement++;?>
            </td>
            <td id="class"><?= $result[0] ?></td>
            <td id="class"><?= $result[1] ?></td>
            <td id="class"><?= $result[2] ?></td>
            <td id="class"><?= $result[3] ?></td>
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
<div id="kevin">
    <h4>index :</h4>
    <p>Roi du fut = vainqueurs <br/>
    Videur de fut = Meilleurs attaquant<br/>
    Gardien du fut = Meilleurs Défenseur<br/></p>
</div>
<button onclick="window.location.href='../../Controller/Connect/CheckConnect.php'">Retour</button>
</body>
<footer><center><p>-----<br>Références: Chôlage Quarouble, IUT Valenciennes Campus de Maubeuge<br>
            Projet Réalisé dans le cadre de la SAE 3.01<br>
            Références:<br>
            Michel Ewan | Meriaux Thomas | Hostelart Anthony | Faës Hugo | Benredouane Ilies<br>
            A destination de: <br>
            Philippe Polet<br>-----</p></center></footer>
</html><?php
} else {
    header('location: ../../Controller/Connect/checkConnect.php');
}