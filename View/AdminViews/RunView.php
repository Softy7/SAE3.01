<?php
session_start();
 require_once('../../ConnexionDataBase.php');
 //require_once ('../../View/AdminViews/RunView.css');
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
            function remplirChampsRun(titre,lien,pdd,pda,paris) {
                if (confirmerModificationRun(id)) {
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
        <input type="file" id="lien" name="lien" accept="image/*" required><br>
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
                    echo "Image : <img src='" . $row['path'] . "'><br>";
                    echo "Point de depart: <input id='pdd" . $row['title'] . "' name='point de départ" . $row['title'] . "'>" . htmlspecialchars($row['starterpoint']) . "</input><br>";
                    echo "Point d'arrive: <input id='pda" . $row['title'] . "' name='point d arrive" . $row['title'] . "'>" . htmlspecialchars($row['finalpoint']) . "</input><br>";
                    echo "Paris Max: <input id='paris" . $row['title'] . "' name='parisMax" . $row['title'] . "'>" . htmlspecialchars($row['maxbet']) . "</input><br>";
                    echo "<button onclick='return remplirChampsRun(" . $row['title'] . ", \"" . htmlspecialchars($row['title']) . "\", \"" . htmlspecialchars($row['title']) . "\")' type='submit' name='modifier_" . $row['title'] . "'>Modifier</button>";
                    echo "<button onclick='return confirmerSuppressionRun(" . $row['title'] . ")' type='submit' name='supprimer' value='" . $row['title'] . "'>Supprimer</button>";
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