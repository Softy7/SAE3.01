<?php
require_once ('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');
require_once ('../launch.php');
session_start();
$bdd = __init__();
$user = launch();
if (!$bdd) {
    echo "Erreur de connexion à la base de données.";
} else {
    if (isset($_POST['publier'])) {
        $titre = $_POST['titre'];
        $pdd = $_POST['pdd'];
        $pda = $_POST['pda'];
        $bet= $_POST['bet'];
        $uploadDir = '../../View/AdminViews/image/';
        echo $uploadDir;
        $uploadFile = $uploadDir.basename($_FILES['lien']['name']);
        echo $uploadFile;
        if (move_uploaded_file($_FILES['lien']['tmp_name'], $uploadFile)) {
            echo 'Le fichier est valide et a été téléchargé avec succès.';
        } else {
            echo 'Erreur lors du déplacement du fichier téléchargé.';
        }
        $lien=$uploadFile;
        $user->addRun($titre,$lien,$pdd,$pda,$bet,$bdd);
    }

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'modifier') === 0) {
            $idarticle = substr($key, 9);
            $nTitre = $_POST['titre'];
            $nData = $_POST['lien'];
            $nPdd = $_POST['pdd'];
            $nPda = $_POST['pda'];
            $nBet = $_POST['bet'];
            $user->updateRun($nTitre,$nData,$nPdd,$nPda,$idarticle,$nBet,$bdd);



        } elseif (isset($_POST['supprimer']) && $_POST['supprimer'] == $value) {
            echo "yo";
            $titre = $_POST['supprimer'];
            $user->deleteRun($titre,$bdd);
        }
    }
}
header("Location: ../../View/AdminViews/RunView.php");
?>