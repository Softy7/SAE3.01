<?php

require 'Player.php';
class Team {
    public $name;
    public $capitain;
    public $listPlayer;

    public function __construct($name) {
        $this->listPlayer = array();
        $this->name = $name;
    }
    function setCapitain($capi) {
        $this->capitain = $capi;
    }

    function addPlayer($player) {
        $this->listPlayer[-1] = $player;
    }
    function removePlayer($player) {
        $list = array();
        for ($i = 0; $i < count($this->listPlayer)-1; $i++) {
            $list[$i] = $this->listPlayer[$i];
        }
        $this->listPlayer = $list;
    }
}
