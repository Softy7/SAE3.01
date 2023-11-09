<?php
session_start();

if ($_SESSION['isAdmin'] == 1) {
    $bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
    $req = $bdd->prepare("SELECT username, mail, name, firstname, birthday FROM Guests WHERE isRegistered = false and isDeleted = true");
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
    <h3>Réadhésion par la "force" ou suppression définitive.</h3>
    <?php
    if($resultat!=null){
        foreach ($resultat as $result){
        ?>
        <form action="../../Controller/AdminFunctions/UnregisterReset.php" method='post'>
            <label><?php echo "Pseudo: ",$result[0], ", Mail: ", $result[1], ", Nom: ", $result[2], ", Prénom: ", $result[3], ", Date de naissance: ", $result[4] ?></label>
            <input type='submit' name="insert_<?php echo $result[0]; ?>" value='Réadhérer'/>
            <input type='submit' name="dessert_<?php echo $result[0]; ?>" value='Balancer'/>
        </form>
        <?php
        }
    }else{
    ?>
<label>Il n'y personne a réinscrire...</label>
        <?php
    }
        ?>
    </body>
    <?php
} else {
    header('location: ../Guest_Home.html');
}