<?php
function launch()
{
    $conn = new PDO("pgsql:host=localhost;dbname=postgres", 'postgres', 'v1c70I83');
    $req = $conn->prepare("Select open from Inscription");
    $req->execute();
    $result = $req->fetchAll();

    if ($result[0][0] == 1) {
        $_SESSION['open'] = 'Inscriptions Ouvertes';
        $_SESSION['openn'] = true;
    } else {
        $_SESSION['open'] = 'Inscriptions Fermees';
        $_SESSION['openn'] = false;
    }

    $tn = null;
    if ($_SESSION['teamName'] != null) {
        $tn = new Team($_SESSION['teamName']);
    }

    $user = null;
    if ($_SESSION['isPlayer'] == 1 && $_SESSION['isAdmin'] == 1 && $_SESSION['captain'] == 1) {
        $user = new AdminCapitain($_SESSION['username'],
            $_SESSION['mail'], $_SESSION['name'],
            $_SESSION['firstname'], $_SESSION['birthday'],
            $_SESSION['password'], $tn);
        $_SESSION['lenght'] = $user->lenghtAdmin($conn);
    } else if ($_SESSION['isPlayer'] == 1 && $_SESSION['isAdmin'] == 1) {
        $user = new PlayerAdministrator($_SESSION['username'],
            $_SESSION['mail'], $_SESSION['name'],
            $_SESSION['firstname'], $_SESSION['birthday'],
            $_SESSION['password'], $tn);
        $_SESSION['lenght'] = $user->lenghtAdmin($conn);
    } else if ($_SESSION['isPlayer'] == 1 && $_SESSION['captain'] == 1) {
        $user = new Capitain($_SESSION['username'],
            $_SESSION['mail'], $_SESSION['name'],
            $_SESSION['firstname'], $_SESSION['birthday'],
            $_SESSION['password'], $tn, array());
    } else if ($_SESSION['isPlayer'] == 1) {
        $user = new Player($_SESSION['username'],
            $_SESSION['mail'], $_SESSION['name'],
            $_SESSION['firstname'], $_SESSION['birthday'],
            $_SESSION['password'], $tn);
    } else if ($_SESSION['isAdmin'] == 1) {
        $user = new Administrator($_SESSION['username'],
            $_SESSION['mail'], $_SESSION['name'],
            $_SESSION['firstname'], $_SESSION['birthday'],
            $_SESSION['password']);
        $_SESSION['lenght'] = $user->lenghtAdmin($conn);
    } else if ($_SESSION['username'] != null) {
        $user = new Member($_SESSION['username'],
            $_SESSION['mail'], $_SESSION['name'],
            $_SESSION['firstname'], $_SESSION['birthday'],
            $_SESSION['password']);
    }
    return $user;
}
