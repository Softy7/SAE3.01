<?php
require_once('../launch.php');
require_once('../../Model/Player.php');
require_once ("../../ConnexionDataBase.php");
require_once ("../../Model/AdminCapitain.php");
require_once ("../../Model/Capitain.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../../vendor/autoload.php');

session_start();
$bdd = __init__();
$use = $_SESSION['username'];
$user = launch();

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'Ask_') !== false) {
            $username = str_replace('Ask_', '', $key);
            echo $username;

            $req= $bdd->prepare("SELECT teamname FROM capitain WHERE username = '$username'");
            $req->execute();
            $reqTeam = $req->fetchAll()[0][0];

            $user->askPlayer($use, $reqTeam);

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
                $mail->Subject = 'Demande a rejoindre équipe';
                $mail->Body = 'Le Joueur ' . $use . ' demande a rejoindre votre équipe, vous pouvez voir la demande sur votre espace';

                // Envoyer le message
                $mail->send();
                echo "<script>alert('Le Captitaine a reçu une demande avec succès.');</script>";
            } catch (Exception $e) {
                echo "<script>alert('Echec de la demande : {$mail->ErrorInfo}');</script>";
            }

            sleep(1);
            header("location: ../../View/Registering/AskJoin.php");
        }
    }

}