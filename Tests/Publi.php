<?php

/*$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
$req = $bdd->prepare("select * from articles order by datePublication");
$req->execute();
$req->fetchall();
*/
$bdd = new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');

$requete = $bdd->prepare("SELECT contenu FROM articles ORDER BY idarticle DESC LIMIT 1;");
$requete->execute();
$resultat = $requete->fetch(PDO::FETCH_ASSOC);

if ($resultat !== false) {
    $text_bdd = $resultat['contenu']; // Récupérer le contenu de la colonne 'contenu'
} else {
    $text_bdd = "";
}

// Explications des modifications :
function formulaire($text)
{
    if ($text == "" || $text == null) {
        $previousText = "Entrez une publication";
    }

    echo '<form action="Publications.php" method="post">';
    echo '<label for="zoneTexte">Entrez un titre :</label><br>';
    echo '<input type="text" name="titre">';
    echo'<br>';
    echo '<label for="zoneTexte">Entrez votre texte :</label><br>';
    echo '<textarea id="zoneTexte" name="texte" rows="10" cols="50" maxlength="100">' . htmlspecialchars($text) . '</textarea><br>';
    echo '<input type="submit" value="Envoyer">';
    echo '</form>';

}

formulaire($text_bdd);
