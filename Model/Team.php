<?php

require_once('Player.php');
class Team {
    public string $name;
    public Capitain $capitain;
    public array $listPlayer;
    public array $listMatch;

    public function __construct($name) {
        $this->listPlayer = array();
        $this->name = $name;
        $this->listMatch = array();
    }
    function setCapitain($capi): bool {
        if ($capi == null) {
            return false;
        } else {
            $this->capitain = $capi;
            return true;
        }
    }

    function addPlayer($player): bool {
        if (count($this->listPlayer)>=5) {
            return false;
        } else {
            $this->listPlayer[-1] = $player;
            $player->setTeam($this);
            return true;
        }
    }

    function removePlayer($player): void {
        $list = array();
        for ($i = 0; $i < count($this->listPlayer); $i++) {
            if ($list[$i] != $player) {
                $list[-1] = $this->listPlayer[$i];
            } else {
                print "Joueur retiré";
            }
        }
        $this->listPlayer = $list;
    }

    function setMatch($match): void {
        $this->listMatch[-1] = $match;
    }
}