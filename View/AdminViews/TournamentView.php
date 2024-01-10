<?php
require_once('../../Controller/AdminFunctions/TournamentTreatment.php');
session_start();

if ($_SESSION['isAdmin'] == 1) {
    $bdd = __init__();
function printTournoi($tournoi) {
    foreach ($tournoi as $parcours => $rencontres) {
        echo "$parcours<br>";
        foreach ($rencontres as $rencontre) {
            echo "$rencontre[0]-$rencontre[1]<br>";
        }echo "</table><br>";
    }
}
$request = $bdd->prepare("SELECT teamname FROM team");
$request->execute();
$equipes_fetch = $request->fetchAll();

$request = $bdd->prepare("SELECT title FROM run");
$request->execute();
$parcours_fetch = $request->fetchAll();

$parcours = array();
foreach ($parcours_fetch as $element) {
    $parcours[] = $element['title'];
}

$equipes = array();
foreach ($equipes_fetch as $element) {
    $equipes[] = $element['teamname'];
}
if (isset($_POST['delete'])) {
    supprimerTableMatch($bdd);
}
if (isset($_POST['insert'])) {
    $tournoi = organiserTournoi($equipes, $parcours);
    remplirTableMatch($tournoi,$bdd);
}
if (isset($_POST['back'])) {
    header('../../Home/Home.php');
    exit();
}

?>

<form method="post">
    <input type="submit" name="show"
           value="Visualiser le tournoi"/>

    <input type="submit" name="delete"
           value="Supprimer le tournoi"/>

    <input type="submit" name="insert"
           value="Générer le tournoi"/>
    <input type="submit" name="back"
           value="retour"/>
</form>
<?php
if (isset($_POST['show'])) {
    $tournoi = organiserTournoi($equipes, $parcours);
    printTournoi($tournoi);
    echo '<form method="post">
            <input type="submit" name="close" value="Fermer la visualisation"/>
          </form>';
}

if (isset($_POST['close'])) {
    header('Location: '. $_SERVER['PHP_SELF']);
    exit();
}
}
