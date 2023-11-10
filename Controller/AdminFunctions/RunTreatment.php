<?php
require_once ('../../Model/Administrator.php');
require_once('../../ConnexionDataBase.php');
session_start();
$bdd = __init__();
$user = launch();
if (!$bdd) {
    echo "Erreur de connexion à la base de données.";
} else {
    if (isset($_POST['publier'])) {
        $titre = $_POST['titre'];
        $lien = $_POST['lien'];
        $pdd = $_POST['pdd'];
        $pda = $_POST['pda'];
        $bet= $_POST['bet'];
        $user->addRun($titre,$lien,$pdd,$pda,$bet,$bdd);
    }

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'modifier_') === 0) {
            $idarticle = substr($key, 9);
            $nouveauTitre = $_POST['titre_' . $idarticle];
            $nouveauContenu = $_POST['contenu_' . $idarticle];

            

        } elseif (isset($_POST['supprimer']) && $_POST['supprimer'] == $value) {
            $titre = $_POST['supprimer'];
            $user->deleteRun($titre,$bdd);
        }
    }
}
header("Location: ../../View/AdminViews/ArticlesEdit.php");
?>