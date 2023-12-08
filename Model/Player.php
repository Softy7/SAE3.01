<?php
include_once('Member.php');
class Player extends Member {
    protected $team;

    /**
     * @param $un "le pseudo du joueur
     * @param $m "le mail du joueur
     * @param $n "le nom du joueur
     * @param $fn "le prénom du joueur
     * @param $b "la date de naissance du joueur écrit sous la forme jj/mm/aaaa
     * @param $p "le mot de passe du joueur
     * @param $t "l'équipe du joueur
     */

    function __construct($un, $m, $n, $fn, $b, $p, $t) {
        parent::__construct($un, $m, $n, $fn, $b, $p);
        $this->team = $t;
    }
    public function getTeam() {
        return $this->team;
    }
    public function setTeam($team) {
        $bdd = __init__();

        $request = $bdd->prepare("update Guests 
                                        set Team = :teamName
                                        where username = :username;");//passe se joueur dans une équipe
        $request->bindValue(':teamName',$team->name,PDO::PARAM_STR);
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        $this->team = $team;
    }

    public function unsetTeam() {
        $bdd = __init__();

        $request = $bdd->prepare("update Guests 
                                        set Team = null
                                        where username = :username;");//retire se joueur son equipe
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
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
        return new Administrator($this->username, $this->getMail(), $this->getName(), ($this->getFirstname()), $this->getBirthday(), $this->getPassword());
    }

    public function createTeam($teamName, $playerUsername, $bdd){
        $requete=$bdd->prepare("INSERT INTO Team VALUES (:teamName,0,0,0)");
        $requete->bindParam(':teamName',$teamName);
        $requete->execute();

        $requete0=$bdd->prepare("INSERT INTO Capitain VALUES (:capUsername,:teamName)");
        $requete0->bindParam(':capUsername',$this->username);
        $requete0->bindParam(':teamName',$teamName);
        $requete0->execute();

        $requete1=$bdd->prepare("UPDATE Guests SET Team=:teamName WHERE username=:playerUsername");
        $requete1->bindParam(':teamName',$teamName);
        $requete1->bindParam(':playerUsername',$playerUsername);
        $requete1->execute();

        $requete2=$bdd->prepare("UPDATE Guests SET Team=:teamName WHERE username=:thisUsername");
        $requete2->bindParam(':teamName',$teamName);
        $requete2->bindParam(':thisUsername',$this->username);
        $requete2->execute();

        return new AdminCapitain($this->username, $this->getMail(), $this->getName(), $this->getFirstname(), $this->getBirthday(), $this->getPassword(), $teamName, array($playerUsername));
    }

    function getTeammates($bdd) {
        $request = $bdd->prepare("Select username from Guests where team = :teamname and username != :username");//retire le capitaine de son equipe
        $request->bindValue(':teamname', $this->team, PDO::PARAM_STR);
        $request->bindValue(':username', $this->username, PDO::PARAM_STR);
        $request->execute();
        return $request->fetchAll();
    }

    public function scearchName($teamName,$bdd){
        $requete = $bdd->prepare("SELECT * FROM Team WHERE teamName=:teamName");
        $requete->bindParam(':teamName',$teamName);
        $requete->execute();
        $isPresent=$requete->fetchAll();
        if ($isPresent!=null) {
            return true;//renvoie true si il est dans la base de donné
        } else {
            return false;//renvoie false si il n'est pas dans la base de donné
        }
    }
}
