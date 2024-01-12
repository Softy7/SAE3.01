<?php
session_start();
if ($_SESSION['message'] != null) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quarouble Cholage Club.fr</title>
</head>
<body>
<h3><?php echo $_SESSION['message'] ?> Vous pouvez retourner sur la page d'accueil.</h3>
<button onclick="window.location.href ='../Guest_Home.html';">Accueil</button>
</body>
</html>
<?php
} else {
    header("location: ../../Controller/Connect/CheckConnect.php");
}