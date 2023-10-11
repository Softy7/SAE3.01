<?php

require_once("Member.php");
class Administrator extends Member {
    public function __construct($un/*username*/, $m/*mail*/, $n/*nom*/, $fn/*prénom*/, $b/*date de naissance*/, $p/*mots de passe*/, $ir/*est en train de s' enregistrer*/)
    {
        parent::__construct($un/*username*/, $m/*mail*/, $n/*nom*/, $fn/*prénom*/, $b/*date de naissance*/, $p/*mots de passe*/, $ir/*est en train de s' enregistrer*/);
    }

    //à modifier
    //passe le visiteur qui est en train de s'enregistrer en membre
    function BecomeMember($un/*username*/, $m/*mail*/, $n/*nom*/, $fn/*prénom*/, $b/*date de naissance*/, $p/*mots de passe*/, $ir/*est en train de s' enregistrer*/) {
        $member = new Member($un/*username*/, $m/*mail*/, $n/*nom*/, $fn/*prénom*/, $b/*date de naissance*/, $p/*mots de passe*/, $ir/*est en train de s' enregistrer*/);
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
    }*/

}
