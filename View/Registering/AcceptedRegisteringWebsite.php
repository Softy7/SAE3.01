<?php
session_start();
if ($_SESSION['message'] != null) {
?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="../Unregistering/css.css" media="screen" type="text/css" />
<head>
    <meta charset="UTF-8">
    <title>Adhésion</title>
</head>
<body>
<center>
<div>
<h3><?php echo $_SESSION['message'] ?> Vous pouvez retourner sur la page d'accueil.</h3>
<input type="submit" value="Accueil" onclick="window.location.href ='../Guest_Home.html';"></div></center>
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
    header("location: ../../Controller/Connect/CheckConnect.php");
}