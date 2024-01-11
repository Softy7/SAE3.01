<?php
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Controller/launch.php');
require_once('../../ConnexionDataBase.php');
session_start();
if ($_SESSION['isPlayer']) {
    $user = launch();
    $teamMates = $user->getTeammates(__init__());
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Cholage Club Quaroule.fr</title>
        <link href="" rel="stylesheet">
    </head>
<body>
<h1>Vue effectif</h1>
<?php
foreach($teamMates as $team) {
    if($team[0]!=$user->username){
        ?>
        <form action="../../Controller/Capitain/Players.php" method="post">
            <label><?php echo "Pseudo: ",$team[0]?></label>
        </form>
        <?php
    }
}
?>
<button onclick="window.location.href='../../Controller/Connect/CheckConnect.php';">Retour</button>
    <?php
} else {
    header('location: ../Home/home.php');
}