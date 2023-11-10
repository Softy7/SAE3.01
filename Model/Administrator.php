<?php

include_once('Member.php');

class Administrator extends Member {
    /**
     * @param String $un le pseudo de l'administrateur
     * @param String $m le mail de l'administrateur
     * @param String $n le nom de l'administrateur
     * @param String $fn le prénom de l'administrateur
     * @param String $b la date de naissance de écrit sous la forme jj/mm/aaaa
     * @param String $p le mot de passe de l'administrateur
     */
    public function __construct($un, $m, $n, $fn, $b, $p)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p);
    }


    /**
     * passe le visiteur qui est en train de s'enregistrer en membre
     *
     * @param $un
     * @param $bdd
     * @return void
     */
     //à modifier
    function BecomeMember($un, $bdd) {
        $req = $bdd->prepare("UPDATE Guests set isregistered = true WHERE username = :username");
        $req->bindValue(':username', $un, PDO::PARAM_STR);
        $req->execute();
    }

    /**
     * obtenir tout les membres qui se sont désinscrit
     *
     * @param $bdd
     * @return void
     */
    function getDeleted($bdd) {
        $req = $bdd->prepare("select username, mail, name, firstname, birthday, password from Guests where isDeleted = true");
        $req->execute();
        return $req->fetchall();
    }

    function getPlayer($bdd){
        $req = $bdd->prepare("select username ,firstname, name, team from Guests where isDeleted = false AND isregistered = true AND isplayer = true ORDER BY team");
        $req->execute();
        return $req->fetchall();
    }

    /**
     * repasse les membres désinscrit en membre
     *
     * @param $username
     * @param $bdd
     * @return void
     */
    function resetDeleted($username, $bdd){
        $req = $bdd->prepare("Update Guests set isDeleted = false where username = :username");
        $req->bindValue(':username', $username, PDO::PARAM_STR);
        $req->execute();
        $req = $bdd->prepare("Update Guests set isRegistered = true where username = :username");
        $req->bindValue(':username', $username, PDO::PARAM_STR);
        $req->execute();
    }

    /**
     * supprime définitivement un membre
     *
     * @param $username
     * @param $bdd
     * @return void
     */
    function deletePermenantly($username, $bdd){
        $req = $bdd->prepare("DELETE FROM Guests WHERE username = :username");
        $req->bindValue(':username', $username, PDO::PARAM_STR);
        $req->execute();
    }


    /**
     * ouvre les inscription du tournois
     *
     * @param $bdd
     * @return void
     */
    function setIsOpen($bdd) {
        $req = $bdd->prepare("UPDATE Inscription SET open = true WHERE open = false");
        $req->execute();
    }


    /**
     * ferme les inscription du tournois
     *
     * @param $bdd
     * @return void
     */
    function setIsClosed($bdd) {
        $req = $bdd->prepare("Update Inscription set open = false WHERE open = true");
        $req->execute();
    }

    function setAdmin($bdd, $username) {
        $req = $bdd->prepare("Update Guests set isAdmin = true where username = :username");
        $bdd->bindValue(':username', $username, PDO::PARAM_STR);
        $req->execute();
}
    /**
     * compte le nombre d'administrateur
     *
     * @param $bdd
     * @return int;
     */
    function lenghtAdmin($bdd) {
        $req = $bdd->prepare("select count(*) from Guests where isAdmin = true");
        $req->execute();
        $req = $req->fetchall();
        return $req[0][0];
    }
    /*function SeeTryRegister() {
        Connexion à la BDD
    }
    function StayMember(Member $member) {
        if ($member->getIsRegistering()) {
            $member->setIsRegistering();
            return true;
        } return false;
    }*/

    /*function addRun($link,$pdd,$pda,$nbpm,$bdd){
        $req = $bdd->prepare("INSERT INTO run VALUES :link,:pdd,:pda,:paris ");
        $req-> blindValues(:link,$link);
        $req-> blindValues(:pdd,$pdd);
        $req-> blindValues(:pda,$pda);
        $req-> blindValues(:paris,$nbpm);
        $req->execute;
    }

    function deleteRun($link,$bdd){
        $req = $bdd->prepare("DELETE * From run where name= :link ");
        $req-> blindValues(:link,$link);
        $req->execute;
    }

    function updateRun($link,$pdd,$pda,$remplacer,$nbpm,$bdd){
    $req = $bdd->prepare("UPDATE run SET name= :link and maxBet= :nbpm AND ima where name= :remplacer ");
    $req-> blindValues(:link,$link);
    $req-> blindValues(:pdd,$pdd);
    $req-> blindValues(:pda,$pda);
    $req-> blindValues(:paris,$nbpm);
    $req-> blindValues(:remplacer,$remplacer);
    $req->execute;
    }*/



}
