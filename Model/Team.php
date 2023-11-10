<?php
require_once('../ConnexionDataBase.php');
class Team {
    public string $name;
    public array $listPlayer;
    public array $listMatch;

    public function __construct($name)
    {
        $this->listPlayer = array();
        $this->name = $name;
        $this->listMatch = array();
        $bdd = __init__();
        $req = $bdd->prepare("select username, mail, name, firstname, birthday, password, isadmin from guests where team = :teamName");
        $req->bindValue(":teamName", $name, PDO::PARAM_STR);
        $req->execute();
        $req = $req->fetchAll();
        $req1 = $bdd->prepare("select username from capitain where teamname = :teamName");
        $req1->bindValue(":teamName", $name, PDO::PARAM_STR);
        $req1->execute();
        $req1 = $req1->fetchAll();
        foreach ($req as $result) {
            if ($req1[0][0] == $result[1] && $result[6] == 1) {
                $this->listPlayer[-1] = new AdminCapitain($result[0], $result[1], $result[2], $result[3], $result[4], $result[5], $this);
            }
            else if ($result[6] == 1) {
                $this->listPlayer[-1] = new PlayerAdministrator($result[0], $result[1], $result[2], $result[3], $result[4], $result[5], $this);
            } else {
                $this->listPlayer[-1] = new Player($result[0], $result[1], $result[2], $result[3], $result[4], $result[5], $this);
            }
        }
    }

    function addPlayer($player): void {
        $bdd = __init__();
        $request=$bdd->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $this->name, PDO::PARAM_STR);
        $request->bindValue(':username',$player->username, PDO::PARAM_STR);
        $request->execute();
        array_push($this->listPlayer,$player);
    }

    function removePlayer($playerUsername): void {//à modifier
        foreach($this->listPlayer as $player){
            if($player->username == $playerUsername){
                unset($this->listPlayer[array_search($player, $this->listPlayer)]);
            }
        }
    }

    function setMatch($match): void {
        $this->listMatch[-1] = $match;
    }


}