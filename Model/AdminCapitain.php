<?php

include('PlayerAdministrator.php');
class AdminCapitain extends PlayerAdministrator {
    function __construct($un, $m, $n, $fn, $b, $p, $tn)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p, $tn);
    }
  
    function addPlayerInTeam($username) {
        $bdd = __init__();
        $request=$bdd->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $this->team, PDO::PARAM_STR);
        $request->bindValue(':username',$username, PDO::PARAM_STR);
        $request->execute();

    }

    function removePlayerInTeam($username) {
        $bdd = __init__();
        $request=$bdd->prepare("delete from Guests where username = :username");
        $request->bindValue(':username',$username, PDO::PARAM_STR);
        $request->execute();
    }

    public function askPlayer($player, $team){
        $bdd = __init__();
        $request = $bdd->prepare("INSERT INTO request VALUES (:Player, false, :team)");
        $request->bindValue(':team', $team, PDO::PARAM_STR);
        $request->bindValue(':Player', $player, PDO::PARAM_STR);
        $request->execute();
    }

    function addPlayer($teamname, $player){
        $bdd = __init__();
        $request = $bdd->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $teamname, PDO::PARAM_STR);
        $request->bindValue(':username', $player, PDO::PARAM_STR);
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

    function searchPlayer($search/*recherche nom,prénom ou username,*/){
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

    function getMatchNotValidated($bdd){
        $requete=$bdd->prepare("SELECT * FROM Match WHERE (contestation IS null) AND (attack=:equipeCap OR defend=:teamCap) ORDER BY(idmatch)");
        $requete->bindParam(':equipeCap',$this->getTeam());
        $requete->bindParam(':teamCap',$this->getTeam());
        $requete->execute();
        $req=$requete->fetchAll();
        return $req;
    }

    function getMatchNotPlayed($bdd){
        $requete=$bdd->prepare("SELECT * FROM Match WHERE (score = 0) AND (attack=:equipeCap OR defend=:teamCap) ORDER BY(idmatch)");
        $requete->bindParam(':equipeCap',$this->getTeam());
        $requete->bindParam(':teamCap',$this->getTeam());
        $requete->execute();
        $req=$requete->fetchAll();
        return $req;
    }

    function insertIntoBet($bdd,$idMatch,$bet){
        $requete1 = $bdd->prepare("INSERT INTO bet VALUES(:cap,:idmatch,:pari)");
        $requete1->bindParam(':cap', $this->username);
        $requete1->bindParam(':idmatch', $idMatch);
        $requete1->bindParam(':pari', $bet);
        $requete1->execute();
    }

    function betIfEquals($bdd,$idMatch,$bet,$team2){
        $min=1;
        $max=2;
        $random = rand($min, $max);
        if ($random==1){
            $requete4 = $bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
            $requete4->bindParam(":equipe1", $this->getTeam());
            $requete4->bindParam(":equipe2", $team2);
            $requete4->bindParam(":bet", $bet);
            $requete4->bindParam(':idMatch',$idMatch);
            $requete4->execute();
        }
        elseif ($random==2){
            $requete5 = $bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
            $requete5->bindParam(":equipe1", $team2);
            $requete5->bindParam(":equipe2", $this->getTeam());
            $requete5->bindParam(":bet", $bet);
            $requete5->bindParam(':idMatch',$idMatch);
            $requete5->execute();
        }

    }

    function bet($bdd,$idMatch,$bet,$team2){
        $requete3 = $bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
        $requete3->bindParam(":equipe1", $this->getTeam());
        $requete3->bindParam(":equipe2", $team2);
        $requete3->bindParam(":bet", $bet);
        $requete3->bindParam(':idMatch',$idMatch);
        $requete3->execute();
    }

    function getBet($bdd,$idMatch){
        $req2=$bdd->prepare("SELECT * FROM bet WHERE (idmatch=:idmatch)");
        $req2->bindParam(':idmatch',$idMatch);
        $req2->execute();
        $resultats2=$req2->fetchAll();
        return $resultats2;
    }

    function viewPlayer($bdd){
        $req = $bdd->prepare("SELECT name, firstname, username FROM Guests WHERE Team is null and isPlayer = true and isDeleted = false");
        $req->execute();
        $resultat = $req->fetchAll();
        return $resultat;
    }

    function enterScore($bdd,$nbDechole,$gameResult,$idMatch){
        $requete = $bdd->prepare("Update Match SET score=:score, goal=:win WHERE idmatch=:idMatch");
        $requete->bindParam(':score',$nbDechole);
        $requete->bindParam(':win', $gameResult);
        $requete->bindParam(':idMatch', $idMatch);
        $requete->execute();
    }

    function enterScorePenal($bdd,$nbCountAttack,$nbCountDefend,$idMatch){
        $requete = $bdd->prepare("Update Match SET countattack=:countattack, countdefend=:countdefend WHERE idmatch=:idMatch");
        $requete->bindParam(':countattack',$nbCountAttack);
        $requete->bindParam(':countdefend', $nbCountDefend);
        $requete->bindParam(':idMatch', $idMatch);
        $requete->execute();
    }

    function confirmation($bdd,$contestation,$idMatch){
        $requete = $bdd->prepare("Update Match SET contestation=:contestation WHERE idmatch=:idMatch");
        $requete->bindParam(':contestation', $contestation);
        $requete->bindParam(':idMatch', $idMatch);
        $requete->execute();
    }

    function checkScoreEntered($bdd){
        $matchsNotValidated=$this->getMatchNotValidated($bdd);
        $matchNotPlayed=$this->getMatchNotPlayed($bdd);
        if ($matchsNotValidated[0][0]==$matchNotPlayed[0][0]){
            return false;
        }
        else{
            return true;
        }
    }

    function checkPenalty($bdd){
        $matchNotPlayed=$this->getMatchNotPlayed($bdd);
        if ($matchNotPlayed[0][7]){
            return true;
        }
        else {
            return false;
        }
    }

}