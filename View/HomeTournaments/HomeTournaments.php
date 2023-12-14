<?php
session_start();

if ($_SESSION['connected']) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Quarouble Chôlage.fr</title>
        <link href="HomeTournaments.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <h1><?php echo $_SESSION['view'] ?></h1>
    <p>Bienvenue sur votre espace de Tournois! Monsieur <?php echo $_SESSION['username']?></p>
    <button onclick="window.location.href='../../Controller/Connect/CheckConnect.php'" id="retour">Retour</button>
    <form action="../../Controller/Connect/Deconnect.php" method="post">
        <input type="submit" value="Déconnexion" id="deconnexion"/>
    </form>
    <?php
    if ($_SESSION['teamName'] != null) {
        ?>
        <p><?php echo 'Vous êtes dans l\'équipe ', $_SESSION['teamName'];?></p>
    <?php
    }

    if($_SESSION['isPlayer']==1){
        ?>
        <!--voir match-->
        <!--voir score-->
        <?php
        if($_SESSION['captain']==1){ ?>
            <button onclick="window.location.href='../Capitain/Bet.php'" id="parier">parier</button>
            <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">entrerScore</button>
            <?php
        }
    }
    ?>
    </body>
    </html>
    <?php
} else {
    header('location: ../Guest_Home.html');
}