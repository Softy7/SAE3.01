<?php

include('Administrator.php');
class PlayerAdministrator extends Administrator {
    private $team;
    function __construct($un, $m, $n, $fn, $b, $p) {
        parent::__construct($un, $m, $n, $fn, $b, $p, false);
    }
    public function setTeam($team) {
        $bdd = new PDO ("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');

        $request = $bdd->prepare("update Guests 
                                        set Team = :teamName
                                        where username = :username;");//passe se joueur dans une équipe
        $request->bindValue(':teamName',$team->name,PDO::PARAM_STR);
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        $this->team = $team;
    }

    public function unsetTeam() {
        $bdd = new PDO ("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');

        $request = $bdd->prepare("update Guests 
                                        set Team = null, capitain = null
                                        where username = :username;");//retire se joueur son equipe
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        $this->team->removePlayer($this);
        $this->team = null;//annule l'équipe affilié
    }

    public function unsetPlayer($bdd){
        //check ouverture insciption, si true utilisation code ci-dessous.
        //check ouverture insciption, si false bloquer l'option.
        $request = $bdd->prepare("update Guests 
                                        set isPlayer = false
                                        where username = :username;");//passe le joueur en tant que membre
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        if ($this->team != null) {// si le joueur est dans une equipe
            $this->unsetTeam();
        }
        $this->team = null;
        return new Administrator($this->username, $this->getMail(), $this->getName(), ($this->getFirstname()), $this->getBirthday(), $this->getPassword(), $this->getIsRegistering());
    }

}