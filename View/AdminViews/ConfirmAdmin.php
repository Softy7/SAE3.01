<?php
session_start();

if ($_SESSION['isAdmin']) {?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Cholage Club Quaroule.fr</title>
    </head>
    <body>
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
    <button onclick="window.location.href='viewAllMember.php';" value="Stop">Annuler</button>
    </body>
    <?php
} else {
    header('location: ../Home/Home.php');
}