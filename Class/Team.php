<?php

require 'Player.php';
class Team {
    public $capitain;
    public $listPlayer=array();

    public function __construct() {

    }

    public function setCapitain($capi)
    {
        $this->capitain = $capi;
    }

    public function addPlayer($player){
        $this->listPlayer[-1] = $player;
    }
    public function removePlayer($player) {
        $list = array();
        for ($i = 0; $i < count($this->listPlayer)-1; $i++) {
            $list[$i] = $this->listPlayer[$i];
        }
        $this->listPlayer = $list;

    }
}