<?php
session_start();
require_once('../launch.php');
require_once('../../Model/Administrator.php');
// Inclusion de la bibliothèque PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../../vendor/autoload.php');

$user = $_SESSION['del'];
$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
if (isset($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'insert_') !== false) {
            $username = str_replace('insert_', '', $key);
            launch()->resetDeleted($username, $bdd);

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
                $mail->Subject = 'Réintégration au site';
                $mail->Body = 'Un administrateur vous a réintégré au site, vous pouvez a nouveau vous connecter';

                // Envoyer le message
                $mail->send();
                echo 'Le message a été envoyé avec succès';
            } catch (Exception $e) {
                echo "Une erreur est survenue lors de l'envoi du message : {$mail->ErrorInfo}";
            }
        } elseif (strpos($key, 'dessert_') !== false) {
            $username = str_replace('dessert_', '', $key);
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
                $mail->Subject = 'Désincription totale';
                $mail->Body = 'Votre désinscription a été définitivement effectuée pour un administrateur, pour vous reconnectez, vous devrez recréer un compte';

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
header("location: ../../View/AdminViews/UnregisteredView.php");
