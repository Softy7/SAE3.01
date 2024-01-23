<?php
session_start();

if ($_SESSION['isAdmin']) {?>
    <!DOCTYPE html>
    <html lang="en">
    <link rel="stylesheet" type="text/css" href="../Unregistering/css.css">
    <head>
        <meta charset="UTF-8">
        <title>Cholage Club Quaroule.fr</title>
    </head>
    <body>
    <center>
    <div>
    <h1>Promouvoir membre</h1>
    <p>Voulez vous Proumouvoir ce membre au rang d'administrateur ? </p>
    <?php
    if (isset($_POST)) {
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'Upgrade_') !== false) {
                $username = str_replace('Upgrade_', '', $key);
    ?>
    <form action='../../Controller/AdminFunctions/ConfirmAdmin.php' method="post">
        <input type='submit' name="Upgrade_<?php echo $username; ?>" value="Promouvoir">
    </form>
            <?php }
        }
    }?>
    <input type="submit" onclick="window.location.href='viewAllMember.php';" value="Annuler"></div></center>
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
    header('location: ../Home/Home.php');
}