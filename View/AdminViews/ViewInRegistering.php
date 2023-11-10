<?php
session_start();
require_once('../../ConnexionDataBase.php');

if ($_SESSION['isAdmin'] == 1) {
$bdd = __init__();
$req = $bdd->prepare("SELECT username, mail, name, firstname, birthday FROM Guests WHERE isRegistered = false and isDeleted = false");
$req->execute();
$resultat = $req->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cholage Club Quaroule.fr</title>
    <link href="inRegistering.css" rel="stylesheet">
</head>
<body>
<h3>Cette page vous sert a accepter ou réfuter les demande d'adhésion</h3>
<?php
if($resultat!=null){
    foreach ($resultat as $result){
?>
<form action="../../Controller/AdminFunctions/isRegisteringCall.php" method='post'>
    <label><?php echo "Pseudo: ",$result[0], ", Mail: ", $result[1], ", Nom: ", $result[2], ", Prénom: ", $result[3], ", Date de naissance: ", $result[4] ?></label>
    <input type='submit' name="accept_<?php echo $result[0]; ?>" value='Accepter'/>
    <input type='submit' name="refuse_<?php echo $result[0]; ?>" value='Refuser'/>
</form>
<?php
    }
}else{
?>
    <label>Il n'y a aucune demande d'adhésion pour le moment...</label>
    <?php
}
?>
<button onclick="window.location.href='../Home/Home.php';" value="Home">Retour à l'Acceuil</button>
</body>
<?php
} else {
    header('location: ../Guest_Home.html');

}
