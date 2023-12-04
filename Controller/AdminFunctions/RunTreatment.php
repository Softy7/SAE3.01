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
        /*$lien = $_POST['lien'];*/
        $lien = file_get_contents($_FILES['lien']['tmp_name']);
        $pdd = $_POST['pdd'];
        $pda = $_POST['pda'];
        $bet= $_POST['bet'];
        $user->addRun($titre,$lien,$pdd,$pda,$bet,$bdd);
    }

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'modifier_') === 0) {
            $idarticle = substr($key, 9);
            $nTitre = $_POST['titre_' . $idarticle];
            $nData = $_POST['lien_' . $idarticle];
            $nPdd = $_POST['pdd_' . $idarticle];
            $nPda = $_POST['pda_' . $idarticle];
            $nBet = $_POST['bet_' . $idarticle];
            $user->updateRun($nTitre,$nData,$nPdd,$nPda,$idarticle,$nBet,$bdd);



            

        } elseif (isset($_POST['supprimer']) && $_POST['supprimer'] == $value) {
            $titre = $_POST['supprimer'];
            $user->deleteRun($titre,$bdd);
        }
    }
}
header("Location: ../../View/AdminViews/ArticlesEdit.php");
?>