<?php
require_once('../../ConnexionDataBaseNR.php');
session_start();
$bdd = __init__();

if (!$bdd) {
    echo "Erreur de connexion à la base de données.";
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['publier'])) {
            $titre = $_POST['titre'];
            $contenu = $_POST['contenu'];
            $writer = $_SESSION['username'];

            $query = $bdd->prepare("INSERT INTO articles (title, contenu, writer, datepublication) VALUES (:titre, :contenu, :writer,date_trunc('second', CURRENT_TIMESTAMP))");
            $query->bindParam(':titre', $titre);
            $query->bindParam(':contenu', $contenu);
            $query->bindParam(':writer', $writer);
            $result = $query->execute();
        }

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'modifier_') === 0) {
                $idarticle = substr($key, 9);
                $nouveauTitre = $_POST['titre_' . $idarticle];
                $nouveauContenu = $_POST['contenu_' . $idarticle];

                $query = $bdd->prepare("UPDATE articles SET title=:nouveauTitre, contenu=:nouveauContenu WHERE idarticle=:idarticle");
                $query->bindParam(':nouveauTitre', $nouveauTitre);
                $query->bindParam(':nouveauContenu', $nouveauContenu);
                $query->bindParam(':idarticle', $idarticle, PDO::PARAM_INT);
                $result = $query->execute();
            } elseif (isset($_POST['supprimer']) && $_POST['supprimer'] == $value) {
                $idarticle = $_POST['supprimer'];

                $query = $bdd->prepare("DELETE FROM articles WHERE idarticle=:idarticle");
                $query->bindParam(':idarticle', $idarticle, PDO::PARAM_INT);
                $result = $query->execute();
            }
        }

        header("location: ../../View/AdminViews/ArticlesEdit.php");
        exit();
    }
}
?>
