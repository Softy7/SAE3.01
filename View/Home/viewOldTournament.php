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

$result = $user->getOldTournament($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quarouble Chômage.fr</title>
    <link rel="stylesheet" href="viewOldTournament.css" media="screen" type="text/css" />
</head>
<body>
<H1>Ancien Classement</H1>
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
        <th>Edition</th>
        <th>Classement</th>
        <th>Equipes</th>
    </tr>
    <?php
    $previousEdition = null;

    foreach ($result as $res) {
        ?>
        <tr>
            <td><?= ($res['edition'] !== $previousEdition) ? $res['edition'] : '' ?></td>
            <td><?= $res['classement'] ?></td>
            <td><?= $res['team'] ?></td>
        </tr>
        <?php
        $previousEdition = $res['edition'];
    }
    ?>
</table>
<button onclick="window.location.href='../HomeTournaments/HomeTournaments.php'">retour</button>
</body>
</html>