<?php
require_once('../../Model/Player.php');
require_once ('../../Model/PlayerAdministrator.php');
require_once('../launch.php');

// Inclusion de la bibliothèque PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../../vendor/autoload.php');
require_once('../../ConnexionDataBase.php');
session_start();
$username = $_SESSION['username'];
$bdd = __init__();
if (isset($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'yes_') !== false) {
            $team = str_replace('yes_', '', $key);
            $Mail=$bdd->prepare("SELECT mail, Capitain.username FROM capitain join guests ON team='$team' Where Guests.username = Capitain.username");
            $Mail->execute();
            $email = $Mail->fetchAll();
            echo $email[0][0];
            echo $email[0][1];

            launch()->addPlayer($team, $username);

            $supp=$bdd->prepare("Delete from request WHERE username = '$username' ");
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
                $mail->addAddress($email[0][0], $email[0][1]);
                $mail->isHTML(true);
                $mail->Subject = 'un nouveau joueur vous a rejoint';
                $mail->Body = $username.' a accepter de rejoindre votre équipe ! Vous pouvez le voir dans votre espace';

                // Envoyer le message
                $mail->send();
                echo 'Le message a été envoyé avec succès';
            } catch (Exception $e) {
                echo "Une erreur est survenue lors de l'envoi du message : {$mail->ErrorInfo}";
            }
        } elseif (strpos($key, 'no_') !== false) {
            $team = str_replace('no_', '', $key);
            $supp=$bdd->prepare("Delete from request WHERE username = '$username' AND team = '$team' ");
            $supp->execute();
            $Mail=$bdd->prepare("SELECT mail, Capitain.username FROM capitain join guests ON team='$team'");
            $Mail->execute();
            $email = $Mail->fetchAll();
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
                $mail->addAddress($email[0][0], $email[0][1]);
                $mail->isHTML(true);
                $mail->Subject = 'Refus de recrutement';
                $mail->Body = $username.' a refusé de rejoindre votre équipe';

                // Envoyer le message
                $mail->send();
                echo 'Le message a été envoyé avec succès';
            } catch (Exception $e) {
                echo "Une erreur est survenue lors de l'envoi du message : {$mail->ErrorInfo}";
            }
        }
    }
}
header("location: ../Connect/CheckConnect.php");