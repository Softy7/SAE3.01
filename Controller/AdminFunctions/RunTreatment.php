<?php
require_once ('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');
require_once ('../launch.php');
session_start();
$bdd = __init__();
$user = launch();
var_dump($_FILES);
if (!$bdd) {
    echo "Erreur de connexion à la base de données.";
} else {
    if (isset($_POST['publier'])) {
        $title = $_POST['titre'];
        $pdd = $_POST['pdd'];
        $pda = $_POST['pda'];
        $bet = $_POST['bet'];
        $order = $_POST['order'];
        $uploadDir = '../../View/AdminViews/image/';
        echo $uploadDir;
        $uploadFile = $uploadDir . basename($_FILES['lien']['name']);
        echo $uploadFile;
        if (move_uploaded_file($_FILES['lien']['tmp_name'], $uploadFile)) {
            echo 'Le fichier est valide et a été téléchargé avec succès.';
        } else {
            echo 'Erreur lors du déplacement du fichier téléchargé.';
        }
        $lien = $uploadFile;
        $user->addRun($title, $lien, $pdd, $pda, $order, $bet, $bdd);
    }

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'modifier_') === 0) {
            $title = substr($key, strlen('modifier_')); // Obtient le titre du parcours à modifier
            $newTitle = $_POST['titre_' . $title];
            if ($_FILES['lien']['name'] != "") {
                $uploadDir = '../../View/AdminViews/image/';
                $uploadFile = $uploadDir . basename($_FILES['lien']['name']);
                if (move_uploaded_file($_FILES['lien']['tmp_name'], $uploadFile)) {
                    echo 'Le fichier est valide et a été téléchargé avec succès.';
                } else {
                    echo 'Erreur lors du déplacement du fichier téléchargé.';
                }
            } else {
                $uploadFile = $user->searchFile($title, $bdd);
            }
            $newData = $uploadFile;
            $newPdd = $_POST['pdd_' . $title];
            $newPda = $_POST['pda_' . $title];
            $newBet = $_POST['bet_' . $title];
            $user->updateRun($newTitle, $newData, $newPdd, $newPda, $title, $newBet, $bdd);

            } elseif (isset($_POST['supprimer']) && $_POST['supprimer'] == $value) {
                $idrun = $_POST['supprimer'];
                $user->deleteRun($idrun, $bdd);
            }
        }
    }
    header("Location: ../../View/AdminViews/RunView.php");
?>
}
