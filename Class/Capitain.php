<?php
require 'Team.php';
require 'Player.php';
class Capitain extends Player {
    public $team;
    function __construct($un, $m, $n, $fn, $b, $p)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p);
    }

    function createTeam() {
        $this->team = new Team();
        $this->team->setCapitain($this);
    }

    function sceachPlayer($namePlayer){
        $bdd = new PDO('postgres:host=localhost;dbname=iutinfo263', 'iutinfo263', '5mTvGJJk');
        $scearchName=$bdd->exec("SELECT FirstName FROM Membre WHERE FirstName=$namePlayer");
        fetchAll($scearchName);
    }

    function addPlayer($namePlayer){

        $this->team :: addPlayer(sceachPlayer($namePlayer)) ;
    }

}
