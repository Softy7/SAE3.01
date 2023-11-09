<?php
session_start();

require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');

if ($_SESSION['isAdmin'] == 1) {
$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
$results = launch()->getPlayer($bdd)

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewAllPlayer.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>Voici les membres inscrit au tournoi cette année :</h1>
<?php
echo "<table><tr><th>pseudo</th><th>Nom</th><th>prénom</th><th>équipe</th></tr>";
foreach ($results as $result){
    echo"<tr><td>$result[0]</td>";
    echo"<td>$result[1]</td>";
    echo"<td>$result[2]</td>";
    if ($result[3] != null) {
        echo"<td>$result[3]</td>";
    }else{
        echo"<td>aucune</td>";
    }
    echo"</tr>";
}
echo"</table>";
?>
<br>
<center><button onclick="window.location.href='../Home/Home.php';" value="Home">Retour sur votre espace</button></center>
</body>
</html>
<?php
} else {
    header('location: ../Guest_Home.html');
}
?>
