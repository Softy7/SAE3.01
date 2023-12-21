<?php


include_once('PlayerAdministrator.php');
class AdminCapitain extends PlayerAdministrator {
    function __construct($un, $m, $n, $fn, $b, $p, $tn)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p, $tn);
    }

    function addPlayerInTeam($player) {
        $bdd = __init__();
        $request=$bdd->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $this->team, PDO::PARAM_STR);
        $request->bindValue(':username',$player, PDO::PARAM_STR);
        $request->execute();
    }

    function removePlayerInTeam($player) {
        $bdd = __init__();
        $request=$bdd->prepare("UPDATE Guests set team = null where username = :username");
        $request->bindValue(':username',$player, PDO::PARAM_STR);
        $request->execute();
    }

    public function deleteTeam(){//dissoudre
        $bdd = __init__();

        $request = $bdd->prepare("Delete 
                                        from capitain
                                        WHERE username = :username ");//retire le capitaine de son equipe
        $request->bindValue(':username', $this->username, PDO::PARAM_STR);
        $request->execute();
        $prepare = $bdd->prepare("UPDATE Guests SET Team=null where Team = :teamname");
        echo $this->team;
        $prepare->bindValue(':teamname', $this->team);
        $prepare->execute();

        $request2 = $bdd->prepare("Delete
                                        From Team
                                        where teamname = :teamname");
        $request2->bindParam(':teamname', $this->team);
        $request2->execute();
        return new PlayerAdministrator($this->username,
            $this->getMail(),
            $this->getName(),
            $this->getFirstname(),
            $this->getBirthday(),
            $this->getPassword(),
            null);
    }

    function searchPlayer($search/*recherche nom,prénom ou username,*/): array{
        $players = array();
        $bdd = __init__();
        $lines = array("username", "name", "firstname");
        for ($i=0; $i<3; $i++) {
            $SUN = $bdd->prepare("SELECT username, name, firstname, team 
                                        FROM Guests 
                                        WHERE :lines = :search");//recherche dans la base de donné
            $SUN->bindParam(':lines',$lines[i]);
            $SUN->bindParam(':search',$search);
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
        $this->team->addPlayer($seachPlayer);
    }

    function bet($match){
        if($match->getTeam1=$this){
            $match->setBetT1($this);
        }
        else{
            $match->setBetT2($this);
        }
    }

    function chooseNewCapitain($playerSelectedUsername){
        $bdd = __init__();
        $request = $bdd->prepare("DELETE FROM capitain WHERE username = :ancienCapUsername");
        $request->bindValue(':ancienCapUsername',$this->username);
        $request->execute();

        $request1 = $bdd->prepare("INSERT INTO Capitain VALUES(:playerSelectedUsername,:teamName)");
        $request1->bindValue(':playerSelectedUsername',$playerSelectedUsername);
        $request1->bindValue(':teamName',$this->team);
        $request1->execute();

        /* passer le joueur choisi en cap
         * setCap le nouveau cap
         * on passe l ancien cap en joueur. */
    }
    /*function addRun($link,$nbpm,$bdd){
       $req = $bdd->prepare("INSERT INTO run VALUES :link,:paris ");
       $req-> blindValues(:link,$link);
       $req-> blindValues(:paris,$nbpm);
       $req->execute;
   }

   function deleteRun($link,$bdd){
       $req = $bdd->prepare("DELETE * From run where name= :link ");
       $req-> blindValues(:link,$link);
       $req->execute;
   }

   function updateRun($link,$remplacer,$nbpm,$bdd){
   $req = $bdd->prepare("UPDATE run SET name= :link and maxBet= :nbpm where name= :remplacer ");
   $req-> blindValues(:link,$link);
   $req-> blindValues(:paris,$nbpm);
   $req-> blindValues(:remplacer,$remplacer);
   $req->execute;
   }*/
}