<?php
require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Controller/launch.php');
session_start();
if ($_SESSION['captain'] == 1) {
$user = launch();
$teamMates = $user->getTeammates(new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83'));
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
        <input type='submit' name="set_capitain_<?php echo $team[0]; ?>" value="Promouvoir Capitaine"/>
        <input type='submit' name="remove_player_<?php echo $team[0]; ?>" value="Retirer Joueur"/>
    </form>
    <?php
    }
}
?>
    <button onclick="window.location.href='../../Controller/Connect/CheckConnect.php';">Retour</button>
    <?php
} else {
    header('location: ../Guest_home.html');
}