<?php

require_once("Member.php");
class Administrator extends Member {
    public function __construct($un, $m, $n, $fn, $b, $p, $ir)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p, $ir);
    }
    function BecomeMember($un, $m, $n, $fn, $b, $p, $ir) {
        $member = new Member($un, $m, $n, $fn, $b, $p, $ir);
        /* Partie export dans la base de donnée */
    }


    //passe ouvre les inscription du tournois.
    function setIsOpen($bdd) {
        $req = $bdd->prepare("UPDATE Inscription SET open = true WHERE open = false");
        $req->execute();
    }

    //passe ferme les inscription du tournois.
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

}
