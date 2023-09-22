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

    function updateTeam($player){
        /*
         * dois pouvoir voir la liste de joueur
         * condition si joueur choisi
         *   retirer joueur
         * sinon
         *   ajouter joueur
         */
    }

    function deleteTeam(){
        unset($this->team);
    }

    function searchPlayer($search): array{
        $players = array();
        $bdd = new PDO ("pgsql:host=iutinfo-sgbd;dbname=iutinfo263",'iutinfo263','5mTvGJJk');
        $lines = array("username", "name", "firstname");
        for ($i=0; $i<3; $i++) {
            $SUN = $bdd->prepare("SELECT username, name, firstname, team 
                                        FROM Guests 
                                        WHERE $lines[i] = '$search'");
            $SUN->execute();
            $SUN = $SUN->fetchAll();
            foreach ($SUN as $row) {
                $attributes = array();
                $attributes[0] = $row['username']; // Accède à la colonne 'username'
                $attributes[1] = $row['name'];    // Accède à la colonne 'name'
                $attributes[2] = $row['firstname']; // Accède à la colonne 'firstname'
                $attributes[3] = $row['team'];  // accède à la colonne 'Team'
                $players[-1] = $attributes;
            }
        }
        return $players;
    }

    function addPlayer($seachPlayer){
        $this->team :: addPlayer($seachPlayer);
    }

    function bet($match){
        if($match->getTeam1=$this){
            $match->setBetT1($this);
        }
        else{
            $match->setBetT2($this);
        }
    }



}
