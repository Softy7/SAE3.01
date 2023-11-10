<?php
session_start();
// Inclusion de la bibliothèque PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../../vendor/autoload.php');
require_once('../launch.php');
require_once('../../Model/PlayerAdministrator.php');


$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
if (isset($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'accept_') !== false) {
            $username = str_replace('accept_', '', $key);
            launch()->BecomeMember($username, $bdd);
            $reqMail = $bdd->prepare("SELECT mail FROM guests WHERE username = '$username'");
            $reqMail->execute();
            $email = $reqMail->fetchAll()[0][0];
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
                $mail->Subject = 'Demande acceptée';
                $mail->Body = 'Votre demande d\'adhésion a bien été acceptée, vous pouvez maintenant vous connecter et accéder à toutes nos fonctionnalitées.';

                // Envoyer le message
                $mail->send();
                echo 'Le message a été envoyé avec succès';
            } catch (Exception $e) {
                echo "Une erreur est survenue lors de l'envoi du message : {$mail->ErrorInfo}";
            }
        } elseif (strpos($key, 'refuse_') !== false) {
            $username = str_replace('refuse_', '', $key);
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
                $mail->Subject = 'Demande refusée';
                $mail->Body = 'Votre demande d\'adhésion a été refusée, vos informations ont été rejetées par l\'administrateur.' ;

                // Envoyer le message
                $mail->send();
                echo 'Le message a été envoyé avec succès';
            } catch (Exception $e) {
                echo "Une erreur est survenue lors de l'envoi du message : {$mail->ErrorInfo}";
            }
            launch()->deletePermenantly($username, $bdd);
        }
    }
}
header("location: ../../View/AdminViews/ViewInRegistering.php");
?>
