<?php

require_once('../../Controller/launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once('../../ConnexionDataBase.php');
session_start();
if ($_SESSION['isAdmin'] == 1) {
$bdd = __init__();
$results = launch()->getMember($bdd, $_SESSION['username'])

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="viewAllMember.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>Voici les membres inscrits au site :</h1>
<?php
echo "<table><tr><th>pseudo</th><th>Nom</th><th>prénom</th><th>Joueur</th><th>équipe</th><th>Admin</th></tr>";
foreach ($results as $res){
    echo"<tr><td>$res[0]</td>";
    echo"<td>$res[1]</td>";
    echo"<td>$res[2]</td>";
    if ($res[3]) {
        echo"<td>oui</td>";
    }else{
        echo"<td>non</td>";
    }if ($res[3] != null) {
        echo"<td>$res[3]</td>";
    }else{
        echo"<td>aucune</td>";
    }if ($res[4] != null) {
        echo"<td>c'est un admin</td>";
    }else{
        ?>
        <td>non   <form action='ConfirmAdmin.php' method="post">
                    <input type='submit' name="Upgrade_<?php echo $res[0]; ?>" value="Promouvoir">
            </form>
        </td>
        <?php
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
