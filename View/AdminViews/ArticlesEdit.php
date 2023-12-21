<?php
session_start();
require_once('../../ConnexionDataBase.php');
if ($_SESSION['isAdmin'] == 1) {
?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="UTF-8">
        <title>Gestion des Publications</title>
        <script>
            function confirmerModification(id) {
                return confirm("Êtes-vous sûr de vouloir modifier la publication " + id + "?");
            }

            function confirmerSuppression(id) {
                return confirm("Êtes-vous sûr de vouloir supprimer la publication " + id + "?");
            }

            function confirmerPublication(){
                return confirm("Êtes-vous sûr de vouloir publier votre texte ?");
        function confirmerPublication(){
            return confirm("Êtes-vous sûr de vouloir publier le parcours ?");
        }
        function remplirChamps(id, titre, contenu) {
            if (confirmerModification(id)) {
                document.getElementById("titre").value = titre;
                document.getElementById("contenu").value = contenu;
                return true;
            }
            function remplirChamps(id, titre, contenu) {
                if (confirmerModification(id)) {
                    document.getElementById("titre").value = titre;
                    document.getElementById("contenu").value = contenu;
                    return true;
                }
                return false;
            }
            document.addEventListener("DOMContentLoaded", function() {
                var textareas = document.querySelectorAll('.auto-resize');

                textareas.forEach(function(textarea) {
                    textarea.addEventListener('input', function () {
                        this.style.height = 'auto';
                        this.style.height = (this.scrollHeight) + 'px';
                    });
                    textarea.dispatchEvent(new Event('input'));
                });
            });
        </script>
    </head>
    <body>
    <h1 id="gestion_publi">Gestion des Publications</h1>
    <h2>Nouvelle Publication</h2>
    <form action="../../Controller/AdminFunctions/ArticleTreatment.php" method="post" onsubmit="return confirmerPublication();">
        <div>
            <label for="titre">Titre :</label>
            <input class='auto-resize' type="text" id="titre" name="titre" required><br>
            <label for="contenu">Contenu :</label>
            <textarea class='auto-resize' id="contenu" name="contenu" required></textarea><br>
            <input type="submit" name="publier" value="Publier">
        </div>
    </form>
    <h2>Publications Existantes</h2>
    <form action="../../Controller/AdminFunctions/ArticleTreatment.php" method="post">
        <?php
        $bdd = __init__();

        if (!$bdd) {
            echo "Erreur de connexion à la base de données. Veuillez réessayer";
        } else {
            $request = $bdd->prepare("SELECT * FROM articles ORDER BY datepublication DESC");
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    echo "<div>";
                    echo "ID: " . $row['idarticle'] . "<br>";
                    echo "date: " . $row['datepublication'] . "<br>";
                    echo "Auteur: ". $row['writer']."<br>";
                    echo "Titre: <input class='auto-resize' type='text' id='titre_" . $row['idarticle'] . "' name='titre_" . $row['idarticle'] . "' value='" . htmlspecialchars($row['title']) . "'><br>";
                    echo "Contenu: <textarea class='auto-resize' id='contenu_" . $row['idarticle'] . "' name='contenu_" . $row['idarticle'] . "'>" . htmlspecialchars($row['contenu']) . "</textarea><br>";
                    echo "<button id='modif' onclick='return remplirChamps(" . $row['idarticle'] . ", \"" . htmlspecialchars($row['title']) . "\", \"" . htmlspecialchars($row['contenu']) . "\")' type='submit' name='modifier_" . $row['idarticle'] . "'>Modifier</button>";
                    echo "<button onclick='return confirmerSuppression(" . $row['idarticle'] . ")' type='submit' name='supprimer' value='" . $row['idarticle'] . "'>Supprimer</button>";
                    echo "</div><br>";
                }
            } else {
                echo "Aucune publication trouvée.";
            }
        }
        ?>
    </form>
<button onclick="window.location.href='../../Controller/Connect/CheckConnect.php';">Retour</button>
</body>
</html>
<?php
} else {
    header('location:../../Controller/Connect/CheckConnect.php');
}