<?php

require "Member.php";
require "become.php";
class Administrator extends Member {
    public function __construct($un, $m, $n, $fn, $b, $p, $ir)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p, $ir);
    }
    function BecomeMember($un, $m, $n, $fn, $b, $p, $ir) {
        $member = new Member($un, $m, $n, $fn, $b, $p, $ir);
        /* Partie export dans la base de donnée */
    }
    function BecomePlayer(Member $member) {
        new Player($member->username,
            $member->getMail(),
            $member->getName(),
            $member->getFirstname(),
            $member->getBirthday(),
            $member->getPassword()
        );
        unset($member);
    }
    function SeeTryRegister() {
        /*Connexion à la BDD*/
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
    function setScore($match) {
        $match->setGoal();
    }

}
