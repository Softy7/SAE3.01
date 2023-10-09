<?php
$conn = new PDO ("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
$name = $_POST['name'];
$FirstName = $_POST['firstname'];
$email = $_POST['email'];
$Birth = $_POST['birth'];
$User = $_POST['user'];
$Password = $_POST['password'];

$req = $conn->prepare("Select open from Inscription");
$req->execute();
$result = $req->fetchAll();

if ($result[0][0] == 1) {
    if ($name == null ||
    $FirstName == null ||
    $email == null ||
    $Birth == null ||
    $User == null ||
    $Password == null) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ChomeurCholeur.fr</title>
    </head>
    <body>
    <h3>Votre inscription a été réfutée, veuillez remplir tous les champs sinon on ne peut pas vous inscrire !</h3>
    <button onclick="window.location.href ='Guest_Home.html';">Accueil</button>
    </body>
    </html>
    <?php
    } else {
    $stmt = $conn->prepare("select username, mail from Guests where username = '$User' or mail = '$email';");
    $stmt->execute();
    $stmt = $stmt->fetchAll();
    if ($stmt == null) {
        $stmt = $conn->prepare("INSERT INTO Guests VALUES ('$User', '$email', '$name', '$FirstName', '$Birth', '$Password', true, false, true, null, null)");
        $stmt->execute();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <title>ChomeurCholeur.fr</title>
        </head>
        <body>
        <h3>Votre inscription a bien été prise en compte vous pourrez vous connectez quand un administrateur approuvera votre inscription</h3>
        <button onclick="window.location.href ='Guest_Home.html';">Accueil</button>
        </body>
        </html>
        <?php
        } else if ($stmt[0][0] == $User) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>ChomeurCholeur.fr</title>
        </head>
        <body>
        <h3>Votre inscription a été réfutée, votre identifiant est déjà utilisé.</h3>
        <button onclick="window.location.href ='Guest_Home.html';">Accueil</button>
        </body>
        </html>
        <?php
        } else if ($stmt[0][1] == $email) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>ChomeurCholeur.fr</title>
        </head>
        <body>
        <h3>Votre inscription a été réfutée, l'adresse mail saisie est déjà utilisée.</h3>
        <button onclick="window.location.href ='Guest_Home.html';">Accueil</button>
        </body>
        </html>
        <?php
        }
    }
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ChomeurCholeur.fr</title>
    </head>
    <body>
    <h3>Votre inscription a été réfutée, malheureusement elles sont fermées ! Veuillez réessayer plus tard...</h3>
    <button onclick="window.location.href ='Guest_Home.html';">Accueil</button>
    </body>
    </html>
    <?php
}
