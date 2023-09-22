<?php

require 'Player.php';
class Team {
    public $name;
    public $capitain;
    public $listPlayer;
    public $listMatch;

    public function __construct($name) {
        $this->listPlayer = array();
        $this->name = $name;
        $this->listMatch = array();
    }
    function setCapitain($capi) {
        $this->capitain = $capi;
    }

    function addPlayer($player) {
        $this->listPlayer[-1] = $player;
        $player->setTeam($this);
    }
    function removePlayer($player) {
        $list = array();
        for ($i = 0; $i < count($this->listPlayer)-1; $i++) {
            $list[$i] = $this->listPlayer[$i];
        }
        $this->listPlayer = $list;
    }

    function setMatch($match) {
        $this->listMatch[-1] = $match;
    }
}