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
                                        where username = :username;");
        $request->bindValue(':teamName',$team->name,PDO::PARAM_STR);
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        $this->team = $team;
    }

    public function unsetTeam() {
        $bdd = new PDO ("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');

        $request = $bdd->prepare("update Guests 
                                        set Team = null, capitain = null
                                        where username = :username;");
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        $this->team->removePlayer($this);
        $this->team = null;
    }

    public function unsetPlayer($bdd){
        //check date si oui faire code ci dessous.
        //check date si oui faire code ci dessous.
        $request = $bdd->prepare("update Guests 
                                        set isPlayer = false
                                        where username = :username;");
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        if ($this->team != null) {
            $this->unsetTeam();
        }
        $this->team = null;
        return new Administrator($this->username, $this->getMail(), $this->getName(), ($this->getFirstname()), $this->getBirthday(), $this->getPassword(), $this->getIsRegistering());
    }

}