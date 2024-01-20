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
        return new Member($this->username, $this->getMail(), $this->getName(), ($this->getFirstname()), $this->getBirthday(), $this->getPassword());
    }

    function addPlayer($teamname, $player){
        $bdd = __init__();
        $request = $bdd->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $teamname, PDO::PARAM_STR);
        $request->bindValue(':username', $player, PDO::PARAM_STR);
        $request->execute();
    }

    public function createTeam($teamName, $playerUsername, $bdd){
        $requete=$bdd->prepare("INSERT INTO Team VALUES (:teamName,0,0,0,0)");
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

    function getTeamsAsk() {
        $req = $this->db->prepare("SELECT request.Team, capitain.username FROM request join public.team t on request.team = t.teamname join capitain on t.teamname = capitain.teamname WHERE request.username=:user AND isplayerask = false");
        $req->bindValue(':user', $this->username, PDO::PARAM_STR);
        $req->execute();
        return $req->fetchAll();
    }

    function getOtherTeams() {
        $req = $this->db->prepare("SELECT guests.team, capitain.username, count(guests.username) FROM guests join capitain ON guests.team = capitain.teamname 
                                        GROUP BY guests.team, capitain.username HAVING count(guests.username) < 4 AND guests.team IS NOT NULL ORDER BY team");
        $req->execute();
        return $req->fetchAll();
    }

    function checkRequest($team) {
        $reqAsk = $this->db->prepare("SELECT Team, isplayerask FROM request WHERE username = :username AND team = :team");
        $reqAsk->bindParam(':username', $this->username);
        $reqAsk->bindParam(':team', $team);
        $reqAsk->execute();
        return $reqAsk->fetchAll();
    }

    public function askPlayer($player, $team){
        $bdd = __init__();
        $request = $bdd->prepare("INSERT INTO request VALUES (:Player, true, :team)");
        $request->bindValue(':team', $team, PDO::PARAM_STR);
        $request->bindValue(':Player', $player, PDO::PARAM_STR);
        $request->execute();
    }

    function getTeammates($bdd) {
        $request = $bdd->prepare("Select username, mail, name, firstname, isadmin from Guests where team = :teamname and username != :username");//retire le joueur de son equipe
        $request->bindValue(':teamname', $this->getTeam(), PDO::PARAM_STR);
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

    function ableToCreate() {
        $requete = $this->db->prepare("SELECT count(*) from guests where isPlayer = true and team is null");
        $requete->execute();
        return $requete->fetchAll()[0][0] > 3;
    }
    /**/
}
