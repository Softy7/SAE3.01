<?php
require_once('Team.php');
require_once('Member.php');

class Player extends Member {
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
                                        set Team = null
                                        where username = :username;");//retire se joueur son equipe
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        $this->team->removePlayer($this);
        $this->team = null;//annule l'équipe affilié
    }

    //à modifier
    public function unsetPlayer($bdd){
        //check ouverture insciption, si true utilisation code ci-dessous.
        //check ouverture insciption, si false bloquer l'option.

        $request = $bdd->prepare("update Guests 
                                        set isPlayer = false
                                        where username = :username;");//passe le joueur en tant que membre
        $request->bindParam(':username',$this->username);
        $request->execute();
        if ($this->team != null) {// si le joueur est dans une equipe
            $this->unsetTeam();
        }
        return new Member($this->username, $this->getMail(), $this->getName(), ($this->getFirstname()), $this->getBirthday(), $this->getPassword(), $this->getIsRegistering());
    }

    public function createTeam(){
            $this->team = new Team("$this->username Team");
            $this->team->setCapitain($this);

        /* crée une équipe
         * entre le nom de l'equipe
         * recherche dans la bdd si le nom est présent dans la bdd
         * si présent dans la bdd
         *      refuse et demande un autre nom d'equipe
         * sinon
         *      ajoute dans la bdd
         * passe le joueur en capitaine dans la bdd
         */
    }
}
