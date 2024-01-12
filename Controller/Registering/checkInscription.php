<?php
require_once('../../ConnexionDataBase.php');
require_once('../../Model/Connexion.php');

session_start();

$connexion = new Connexion();

$name = $_POST['name'];
$FirstName = $_POST['firstname'];
$email = $_POST['email'];
$Birth = $_POST['birth'];
$User = $_POST['user'];
$Password = $_POST['password'];
$PasswordC = $_POST['passwordC'];

$check = $connexion->insertNewGuest($name, $FirstName, $email, $Birth, $User, $Password, $PasswordC);
switch($check) {
    case 0:
        $_SESSION['message'] = "Demande d'adhésion prise en compte. Vous serez recontactés par mail. A très bientôt sur notre site ! Monsieur $name, $FirstName, .";
        header('location: ../../View/Registering/AcceptedRegisteringWebsite.php');
    case 1:
        $_SESSION['message'] = "Demande d'adhésion non validée. Utilisateur existant.";
    case 2:
        $_SESSION['message'] = "Demande d'adhésion non validée. Vous devez saisir le même mot de passe ET dans la case du mot de passe ET dans la case de confirmation.";
    case 3:
        $_SESSION['message'] = "Demande d'adhésion non validée. Mot de passe trop court.";
    header("location: ../../View/Registering/RegistRetry.php");
}
