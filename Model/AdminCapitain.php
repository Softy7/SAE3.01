<?php

include('PlayerAdministrator.php');
class AdminCapitain extends PlayerAdministrator {
    function __construct($un, $m, $n, $fn, $b, $p, $tn)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p, $tn);
    }


    function addPlayerInTeam($player) {
        $this->team->addPlayer($player);

    function addPlayerInTeam($username) {
        $bdd = __init__();
        $request=$bdd->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $this->team, PDO::PARAM_STR);
        $request->bindValue(':username',$username, PDO::PARAM_STR);
        $request->execute();
    }

    function removePlayerInTeam($player) {
        $this->team->removePlayer($player);
    }

    public function deleteTeam(){//dissoudre
        $bdd = __init__();

        $request = $bdd->prepare("Delete 
                                        from capitain
                                        WHERE username = :username ");//retire le capitaine de son equipe
        $request->bindValue(':username', $this->username, PDO::PARAM_STR);
        $request->execute();
        $prepare = $bdd->prepare("UPDATE Guests SET Team=null where Team = :teamname");
        echo $this->team->name;
        $prepare->bindValue(':teamname', $this->team->name);
        $prepare->execute();

        $request2 = $bdd->prepare("Delete
                                        From Team
                                        where teamname = :teamname");
        $request2->bindParam(':teamname', $this->team->name);
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

    function betIfEquals(){
        $min=1;
        $max=2;
        $random = rand($min, $max);
        return $random;
    }

    function chooseNewCapitain($playerSelectedUsername){
        $bdd = __init__();
        $request = $bdd->prepare("DELETE FROM capitain WHERE username = :ancienCapUsername");
        $request->bindValue(':ancienCapUsername',$this->username);
        $request->execute();

        $request1 = $bdd->prepare("INSERT INTO Capitain VALUES(:playerSelectedUsername,:teamName)");
        $request1->bindValue(':playerSelectedUsername',$playerSelectedUsername);
        $request1->bindValue(':teamName',$this->team->name);
        $request1->execute();

        /* passer le joueur choisi en cap
         * setCap le nouveau cap
         * on passe l ancien cap en joueur. */
    }
    function addRun($link, $data, $pdd, $pda, $nbpm, $bdd){
        $req = $bdd->prepare("INSERT INTO run VALUES (:link, :data, :pdd, :pda, :paris)");
        $req->bindValue(":link", $link);
        $req->bindValue(":data", $data, PDO::PARAM_LOB);
        $req->bindValue(":pdd", $pdd);
        $req->bindValue(":pda", $pda);
        $req->bindValue(":paris", $nbpm);
        $req->execute();
    }

    function deleteRun($link,$bdd){
        $req = $bdd->prepare("DELETE From run where title= :link ");
        $req-> bindValue(":link",$link);
        $req->execute();
    }

    function updateRun($link,$data,$pdd,$pda,$remplacer,$nbpm,$bdd){
        $req = $bdd->prepare("UPDATE run SET name= :link and maxBet= :nbpm AND image_data=:data And starterPoint=:pdd And starterPoint=:pda  where name= :remplacer ");
        $req-> bindValue(":link",$link);
        $req-> bindValue(":data",$data);
        $req-> bindValue(":pdd",$pdd,PDO::PARAM_LOB);
        $req-> bindValue(":pda",$pda);
        $req-> bindValue(":paris",$nbpm);
        $req-> bindValue(":remplacer",$remplacer);
        $req->execute;
    }
}