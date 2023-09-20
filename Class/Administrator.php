<?php

require "Member.php";
class Administrator extends Member {
    public function __construct($un, $m, $n, $fn, $b, $p, $ir)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p, $ir);
    }

    function BecomePlayer(Member $member) {
        $member->becomePlayer();
        unset($member);
    }
    function SeeTryRegister() {

    }
    function StayMember(Member $member) {
        $member->setIsRegistering();
    }
}