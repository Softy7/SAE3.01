<?php

include_once("Member.php");
class Administrator extends Member {
    public function __construct($un, $m, $n, $fn, $b, $p, $ir)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p, $ir);
    }
    function BecomeMember($un, $m, $n, $fn, $b, $p, $ir) {
        $member = new Member($un, $m, $n, $fn, $b, $p, $ir);
        /* Partie export dans la base de donnée */
    }
    function becomePlayer($bdd) {
        return new PlayerAdministrator($this->username,
            $this->getMail(),
            $this->getName(),
            $this->getFirstname(),
            $this->getBirthday(),
            $this->getPassword()
        );
    }

    function setIsOpen($bdd) {
        $req = $bdd->prepare("UPDATE Inscription SET open = true WHERE open = false");
        $req->execute();
    }

    function setIsClosed($bdd) {
        $req = $bdd->prepare("Update Inscription set open = false WHERE open = true");
        $req->execute();
    }
    /*function SeeTryRegister() {
        Connexion à la BDD
    }
    function StayMember(Member $member) {
        if ($member->getIsRegistering()) {
            $member->setIsRegistering();
            return true;
        } return false;
    }
    function createMatch($team1,$team2,$parcour) {
        $match = new Match($team1,$team2,$parcour);
        $team1->setMatch($match);
        $team2->setMatch($match);
    }
    function gestionMatch($match) {
        $match->setChole();
    }
    function setScore($bdd, $match, $isScored) {
        $match->setGoal($bdd, $match->annee );
    }
*/
}
