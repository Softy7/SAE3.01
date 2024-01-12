<?php
require_once('../launch.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../Model/Capitain.php');
require_once ("../../ConnexionDataBase.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../../vendor/autoload.php');
session_start();
$bdd = __init__();

$user = launch();
$team = $_SESSION['teamName'];

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'Ask_')!==false) {
            $username = str_replace('Ask_', '', $key);
            $user->askPlayer($username, $team);

            $reqMail = $bdd->prepare("SELECT mail FROM guests WHERE username = '$username'");
            $reqMail->execute();
            $email = $reqMail->fetchAll()[0][0];

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
                $mail->Subject = 'Invitation dans une équipe';
                $mail->Body = 'Le Capitaine '.$_SESSION['username'].' vous invite a rejoindre son équipe nommé '.$team.', vous pouvez voir la demande sur votre espace';

                // Envoyer le message
                $mail->send();
                echo "<script>alert('Le Joueur a reçu une demande avec succès.');</script>";
            } catch (Exception $e) {
                echo "<script>alert('Echec de la demande : {$mail->ErrorInfo}');</script>";
            }

            sleep(1);
            header("location: ../../View/Capitain/NewPlayer.php");
        }
    }

}
