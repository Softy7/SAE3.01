<?php
require 'Team.php';
require 'Member.php';

class Player extends Member {
    private $team;

    function __construct($un, $m, $n, $fn, $b, $p) {
        parent::__construct($un, $m, $n, $fn, $b, $p, false);
    }

    public function setTeam($team)
    {
        $this->team = $team;
    }

    function joinTeam($team){
        $this->setTeam($team);
    }
}
