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
            function confirmerModificationRun(id) {
                return confirm("Êtes-vous sûr de vouloir modifier la publication " + id + "?");
            }

            function confirmerSuppressionRun(id) {
                return confirm("Êtes-vous sûr de vouloir supprimer la publication " + id + "?");
            }

            function confirmerPublicationRun(){
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
    <form action="../../Controller/AdminFunctions/RunTreatment.php" method="post" onsubmit="return confirmerPublicationRun();" enctype="multipart/form-data">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required><br>
        <label for="parcours">Parcours:</label>
        <input type="file" id="lien" name="lien" required><br>
        <label for="Départ">Départ :</label>
        <input type="text" id="pdd" name="pdd" required><br>
        <label for="Arrivé">Arrivé :</label>
        <input type="text" id="pda" name="pda" required><br>
        <label for="Paris Maximum">Paris Maximun :</label>
        <input type="number" id="bet" name="bet" required><br>
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
                    $imageData = $row['donnees'];  // Assurez-vous que 'donnees' est le nom correct de votre colonne

// Utilisez stream_get_contents pour convertir la ressource en une chaîne de caractères
                    $imageString = stream_get_contents($imageData);

// Maintenant, vous pouvez utiliser $imageString avec getimagesizefromstring
                    $imageSize = getimagesizefromstring($imageString);
                    $imageMimeType = $imageSize['mime'];
                    echo "Lien: <img id='parcours" . $row['title'] . "' src='data:" . $imageMimeType . ";base64," . base64_encode($row['image_data']) . "' alt='Image' /><br>";
                    /*echo "Lien: <input id='parcours" . $row['title'] . "' name='parcours" . $row['title'] . "'>" . htmlspecialchars($row['image_data']) . "</input><br>";*/
                    echo "Point de depart: <input id='pdd" . $row['title'] . "' name='point de départ" . $row['title'] . "'>" . htmlspecialchars($row['starterPoint']) . "</input><br>";
                    echo "Point d'arrive: <input id='pda" . $row['title'] . "' name='point d arrive" . $row['title'] . "'>" . htmlspecialchars($row['finalPoint']) . "</input><br>";
                    echo "Paris Max: <input id='paris" . $row['title'] . "' name='parisMax" . $row['title'] . "'>" . htmlspecialchars($row['maxBet']) . "</input><br>";
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