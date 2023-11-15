<?php
session_start();
require_once('../../ConnexionDataBase.php');
if ($_SESSION['isAdmin'] == 1) {

    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Gestion des parcours</title>
        <script>
            function confirmerModification(id) {
                return confirm("Êtes-vous sûr de vouloir modifier la publication " + id + "?");
            }

            function confirmerSuppression(id) {
                return confirm("Êtes-vous sûr de vouloir supprimer la publication " + id + "?");
            }

            function confirmerPublication(){
                return confirm("Êtes-vous sûr de vouloir publier votre texte ?");
            }
            function remplirChamps(titre,lien,pdd,pda,paris) {
                if (confirmerModification(id)) {
                    document.getElementById("titre").value = titre;
                    document.getElementById("lien").value = lien;
                    document.getElementById("pdd").value = pdd;
                    document.getElementById("pda").value = pda;
                    document.getElementById("bet").value = paris;
                    return true;
                }
                return false;
            }
        </script>
    </head>
    <body>
    <h1>Gestion des Parcours</h1>
    <h2>Nouveau Parcours</h2>
    <form action="../../Controller/AdminFunctions/RunTreatment.php" method="post" onsubmit="return confirmerPublication();">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required><br>
        <label for="contenu">Contenu :</label>
        <textarea id="lien" name="lien du parcours" required></textarea>
        <textarea id="pdd" name="point de départ" required></textarea>
        <textarea id="pda" name="point d'arrivé" required></textarea>
        <textarea id="bet" name="paris max" required></textarea>
        <br>
        <input type="submit" name="publier" value="Publier">
    </form>
    <h2>Parcours Existants</h2>
    <form action="../../Controller/AdminFunctions/RunTreatment.php" method="post">
        <?php
        $bdd = __init__();

        if (!$bdd) {
            echo "Erreur de connexion à la base de données.";
        } else {
            $request = $bdd->prepare("SELECT * FROM run ORDER BY maxBet DESC");
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                foreach ($result as $row) {
                    echo "<div>";
                    echo "Titre: <input type='text' id='titre_" . $row['title'] . "' name='titre_" . $row['title'] . "' value='" . htmlspecialchars($row['title']) . "'><br>";
                    echo "Lien: <textarea id='image" . $row['title'] . "' name='parcours" . $row['title'] . "'>" . htmlspecialchars($row['image_data']) . "</textarea><br>";
                    echo "Point de depart: <textarea id='pdd" . $row['title'] . "' name='point de départ" . $row['title'] . "'>" . htmlspecialchars($row['starterPoint']) . "</textarea><br>";
                    echo "Point d'arrive: <textarea id='pda" . $row['title'] . "' name='point d'arrive" . $row['title'] . "'>" . htmlspecialchars($row['finalPoint']) . "</textarea><br>";
                    echo "Paris Max: <textarea id='paris" . $row['title'] . "' name='parisMax" . $row['title'] . "'>" . htmlspecialchars($row['maxBet']) . "</textarea><br>";
                    echo "<button onclick='return remplirChamps(" . $row['idarticle'] . ", \"" . htmlspecialchars($row['title']) . "\", \"" . htmlspecialchars($row['contenu']) . "\")' type='submit' name='modifier_" . $row['idarticle'] . "'>Modifier</button>";
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