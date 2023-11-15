<?php
require_once('../../ConnexionDataBase.php');
session_start();
$bdd = __init__();
$requete = $bdd->prepare("SELECT * FROM Guests WHERE Team is null and isPlayer = true and username != :username");
$requete->bindValue(':username', $_SESSION['username'],PDO::PARAM_STR );
$requete->execute();
$donnees = $requete->fetchAll();

if ($_SESSION['connected']) {?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8">
    <title>Formulaire creation d'équipe</title>
    <link href="form.css" rel="stylesheet">
</head>
<body>
<main>
    <header>
    </header>
    <form action="../../Controller/Capitain/CreateTeam.php" method="post">
        <div class="page" id="page1">
            <h1>Entrer votre nom d'équipe</h1>
            <div>
                <label>Nom d'équipe:</label>
                <input id="entreNom" type="text" name="teamName">
            </div>
            <button type="button">Suivant</button>
        </div>
        <div class="page" id="page">
            <?php
            foreach ($donnees as $result){

                ?>
                <label><?php echo "Pseudo: ",$result[0]?></label>
                <input type='submit' name="add_team_<?php echo $result[0]; ?>" value="+"/>

                <br>
                <?php
            }
            ?>
        </div>
    </form>
    <button onclick="window.location.href='../../Controller/Connect/CheckConnect.php'">Retour</button>

</main>


<script src="form.js"></script>
</body>
</html>
<?php
} else {
    header('location: ../Guest_Home.html');
}