<?php

$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
    $nouveauTexte = $_POST["texte"];
    $titre = $_POST["titre"];
    $requete = $bdd->prepare("select max(idArticle) from articles");
    $requete->execute();
    $res = $requete->fetchAll();
    $res = $res[0][0];
    if ($res == null) {
        $res = 1;
    } else {
        $res++;
    }
    $requete = $bdd->prepare("INSERT INTO articles VALUES (:res,:titre,:contenu, 'Softy16', NOW(%Y))");
    $requete->bindParam(':contenu', $nouveauTexte);
    $requete->bindParam(':res', $res);
    $requete->bindParam('titre',$titre);
    $requete->execute();

// redirige vers la page de publication
header("Location: publi.php");
exit();
?>