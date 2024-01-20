<?php
require_once('../../Model/Capitain.php');
require_once('../launch.php');
require_once('../../Model/AdminCapitain.php');
session_start();

// Inclusion de la bibliothèque PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../../vendor/autoload.php');
require_once('../../ConnexionDataBase.php');

$user = $_SESSION['username'];
$team = $_SESSION['teamName'];
$bdd = __init__();
if (isset($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'yes_') !== false) {
            $username = str_replace('yes_', '', $key);
            $reqMail = $bdd->prepare("SELECT mail FROM guests WHERE username = '$username'");
            $reqMail->execute();
            $email = $reqMail->fetchall()[0][0];

            launch()->addPlayer($team, $username);

            $supp=$bdd->prepare("Delete from request WHERE username = '$username'");
            $supp->execute();

            // créé mail de réponse
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            try {
                // Paramètres du serveur SMTP de Outlook
                $mail->isSMTP();
                $mail->Host = 'smtp.office365.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'cholage.quarouble@outlook.fr'; // adresse e-mail Outlook
                $mail->Password = 'CholageQuarouble'; // mot de passe Outlook
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Destinataire et contenu du message
                $mail->setFrom('cholage.quarouble@outlook.fr', 'Cholage Quarouble');
                $mail->addAddress($email, $username);
                $mail->isHTML(true);
                $mail->Subject = 'Vous avez été pris';
                $mail->Body = $user.' vous a accepter dans son équipe ! Vous faites désormer parti des '.$team;

                // Envoyer le message
                $mail->send();
                echo 'Le message a été envoyé avec succès';
            } catch (Exception $e) {
                echo "Une erreur est survenue lors de l'envoi du message : {$mail->ErrorInfo}";
            }
        } elseif (strpos($key, 'no_') !== false) {
            $username = str_replace('no_', '', $key);
            $supp=$bdd->prepare("Delete from request WHERE username = '$username' AND team = '$team' ");
            $supp->execute();
            $reqMail = $bdd->prepare("SELECT mail FROM guests WHERE username = '$username'");
            $reqMail->execute();
            $email = $reqMail->fetchAll()[0][0];
            //créé mail de reponse
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            try {
                // Paramètres du serveur SMTP de Outlook
                $mail->isSMTP();
                $mail->Host = 'smtp.office365.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'cholage.quarouble@outlook.fr'; // adresse e-mail Outlook
                $mail->Password = 'CholageQuarouble'; // mot de passe Outlook
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Destinataire et contenu du message
                $mail->setFrom('cholage.quarouble@outlook.fr', 'Cholage Quarouble');
                $mail->addAddress($email, $username);
                $mail->isHTML(true);
                $mail->Subject = 'Refus de recrutement';
                $mail->Body = $user.' ne vous a pas accepté dans son équipe';

                // Envoyer le message
                $mail->send();
                echo 'Le message a été envoyé avec succès';
            } catch (Exception $e) {
                echo "Une erreur est survenue lors de l'envoi du message : {$mail->ErrorInfo}";
            }
        }
    }
}
header("location: ../../View/Capitain/ViewRequest.php");