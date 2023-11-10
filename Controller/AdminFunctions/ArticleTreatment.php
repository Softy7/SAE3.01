<?php
session_start();
$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');

if (!$bdd) {
    echo "Erreur de connexion à la base de données.";
} else {
    if (isset($_POST['publier'])) {
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $writer = $_SESSION['username'];
        $datePublication = date("Y-m-d");

        $query = $bdd->prepare("INSERT INTO articles (title, contenu, writer, datepublication) VALUES (:titre, :contenu, :writer, :datePublication)");
        $query->bindParam(':titre', $titre);
        $query->bindParam(':contenu', $contenu);
        $query->bindParam(':writer', $writer);
        $query->bindParam(':datePublication', $datePublication);
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
}
header("Location: ../../View/AdminViews/ArticlesEdit.php");
?>
